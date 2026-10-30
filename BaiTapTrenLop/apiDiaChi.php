<?php
// ===== CẤU HÌNH =====
$cfg = [
    'api_key'   => getenv('TTP_API_KEY') ?: 'hvn_live_JgiDY8BA4FGN1rtMmpQ9A63iRrkYMDR0',
    'base_url'  => 'https://tinhthanhpho.com/api/v1',
    'cache_ttl' => 3600,    // cache danh sách tỉnh/huyện/xã (giây)
    'conv_ttl'  => 86400,   // cache kết quả chuyển đổi
];

/** Gọi API tinhthanhpho.com. Trả về ['status'=>int, 'json'=>array|null, 'error'=>string] */
function ttp(array $cfg, string $method, string$path, array $query = [], ?array $body = null, bool $auth = false, int$ttl = 0): array
{
    $url = $cfg['base_url'] .$path . ($query ? '?' . http_build_query($query) : '');
    $cacheFile = sys_get_temp_dir() . '/ttp_' . md5($method . $url . json_encode($body)) . '.json';
    if ($ttl && is_file($cacheFile) && time() - filemtime($cacheFile) <$ttl) {
        return ['status' => 200, 'json' => json_decode(file_get_contents($cacheFile), true), 'error' => ''];
    }
    $headers = ['Accept: application/json'];
    if ($auth)$headers[] = 'Authorization: Bearer ' . $cfg['api_key'];$opts = [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20, CURLOPT_CUSTOMREQUEST =>$method];
    if ($body !== null) {$headers[] = 'Content-Type: application/json';
        $opts[CURLOPT_POSTFIELDS] = json_encode($body, JSON_UNESCAPED_UNICODE);
    }
    $opts[CURLOPT_HTTPHEADER] =$headers;
    $ch = curl_init();
    curl_setopt_array($ch,$opts);
    $res    = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err    = curl_error($ch);
    curl_close($ch);$json = $res ? json_decode($res, true) : null;
    if ($ttl &&$status == 200 && is_array($json) && !empty($json['success'])) file_put_contents($cacheFile,$res);
    return ['status' => $status, 'json' => $json, 'error' =>$err];
}

function out(array $a): void { 
    header('Content-Type: application/json; charset=utf-8'); 
    echo json_encode($a, JSON_UNESCAPED_UNICODE); 
    exit; 
}

/** Lấy toàn bộ các trang của một danh sách */
function ttp_list(array $cfg, string$path): void
{
    $all = [];
    for ($page = 1; $page <= 10; $page++) {$r = ttp($cfg, 'GET',$path, ['limit' => 100, 'page' => $page], null, false,$cfg['cache_ttl']);
        $d =$r['json']['data'] ?? null;
        if (!$d) { 
            if (!$all) {
                out(['ok' => false, 'message' => $r['json']['message'] ?? ($r['error'] ?: 'Không lấy được danh sách (HTTP ' . $r['status'] . ').')]);
            }
            break; 
        }
        foreach ($d as $x) {$all[$x['code']] = ['code' => (string)$x['code'], 'name' => $x['name'], 'type' =>$x['type'] ?? ''];
        }
        if (count($all) >= ($r['json']['metadata']['total'] ?? count($d))) break;
    }
    out(['ok' => true, 'data' => array_values($all)]);
}

// ===== AJAX ROUTER =====
$action =$_GET['action'] ?? '';
$code   = preg_replace('/\D/', '',$_GET['code'] ?? '');

if ($action === 'provinces') ttp_list($cfg, '/provinces');
if ($action === 'districts') ttp_list($cfg, "/provinces/$code/districts");
if ($action === 'wards')     ttp_list($cfg, "/districts/$code/wards");

if ($action === 'province') {$r = ttp($cfg, 'GET', "/merge-history/province/$code", [], null, false, $cfg['cache_ttl']);$rows = $r['json']['data'] ?? [];$mine = null;
    foreach ($rows as$row) if ((string)$row['old_province_code'] ===$code) { $mine =$row; break; }
    if (!$mine) out(['ok' => false, 'message' =>$r['json']['message'] ?? 'Không tìm thấy lịch sử sáp nhập của tỉnh này.']);
    $members = [];
    foreach ($rows as $row) if ((string)$row['new_province_code'] === (string)$mine['new_province_code'] && !empty($row['old_province']['name'])) $members[$row['old_province']['name']] = true;
    $np =$mine['new_province'] ?? [];
    out(['ok' => true, 'old' => $mine['old_province'] ?? null, 'new' => [
        'code' => $np['code'] ?? '', 'name' =>$np['name'] ?? '', 'type' => $np['type'] ?? '', 'hq' =>$np['hq_address'] ?? '',
        'area' => $np['area_km2'] ?? null, 'pop' => $np['population'] ?? null, 'legal' => $np['legal_ref'] ?? '',
    ], 'members' => array_keys($members)]);
}

if ($action === 'convert') { 
    $in = json_decode(file_get_contents('php://input'), true) ?: [];$body = [];
    foreach (['text', 'provinceCode', 'districtCode', 'wardCode', 'streetAddress'] as $k) {$v = trim((string)($in[$k] ?? ''));
        if ($v !== '')$body[$k] = mb_substr($v, 0, 300);
    }
    if (empty($body['text']) && empty($body['wardCode'])) out(['ok' => false, 'message' => 'Hãy nhập địa chỉ hoặc chọn đến Phường/Xã.']);
    if (str_starts_with($cfg['api_key'], 'DAN_API_KEY')) out(['ok' => false, 'message' => 'Chưa cấu hình API key trong index.php.']);
    $r = ttp($cfg, 'POST', '/convert/address', [], $body, true,$cfg['conv_ttl']);
    $j =$r['json'];
    if ($r['status'] == 200 && !empty($j['success'])) out(['ok' => true, 'data' => $j['data']]);$msg = $j['message'] ?? ($r['error'] ?: 'Lỗi HTTP ' . $r['status']);
    if ($r['status'] == 401)$msg = 'API key không hợp lệ hoặc đã bị thu hồi (401).';
    if ($r['status'] == 429)$msg = 'Đã vượt giới hạn lượt gọi, hãy thử lại sau.';
    out(['ok' => false, 'message' => $msg, 'suggestions' => $j['suggestions'] ?? ($j['data']['suggestions'] ?? [])]);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chuyển đổi địa chỉ cũ sang mới</title>
<style>
:root{--red:#ff3b30;--red-dark:#d70015;--bg:#0f0f10;--panel:#18181b;--border:#27272a;--text:#f4f4f5;--mut:#a1a1aa}
*{box-sizing:border-box}
body{font-family:"Google Sans","Be Vietnam Pro",system-ui,sans-serif;margin:0;color:var(--text);background:var(--bg)}
.wrap{max-width:1240px;margin:0 auto;padding:40px 24px 60px}
h1{font-size:42px;line-height:1.15;margin:0 0 10px;letter-spacing:-1px;font-weight:700;color:#fff}
.sub{font-size:16px;color:var(--mut);margin:0 0 40px}
.panel{border:1px solid var(--border);border-radius:24px;background:var(--panel);max-width:1200px;box-shadow:0 20px 40px rgba(0,0,0,0.4)}
.tabs{display:flex;gap:12px;padding:0 16px;border-bottom:1px solid var(--border)}
.tab{border:0;background:none;font-family:inherit;font-size:16px;font-weight:600;color:var(--mut);padding:24px 20px 20px;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;transition:0.2s}
.tab.on{color:var(--red);border-bottom-color:var(--red)}
.body{padding:36px 28px 32px}
.search{display:flex;align-items:center;gap:12px;border:1px solid var(--border);border-radius:14px;padding:8px 8px 8px 20px;height:60px;background:#202024}
.search:focus-within,.field input:focus,.field select:focus{border-color:var(--red);box-shadow:0 0 0 3px rgba(255,59,48,0.25);outline:0}
.search input{flex:1;border:0;outline:0;font-size:18px;font-family:inherit;background:none;color:#fff;min-width:0}
.search svg{flex:none;color:var(--mut)}
.btn{display:inline-flex;align-items:center;gap:10px;border:0;background:var(--red);color:#fff;font-family:inherit;font-weight:600;font-size:16px;padding:0 24px;height:100%;border-radius:10px;cursor:pointer;transition:0.2s}
.btn.big{height:54px;border-radius:14px;padding:0 28px;margin-top:24px;width:100%;justify-content:center}
.btn:hover{background:var(--red-dark)}.btn:disabled{opacity:.55;cursor:wait}
.hint{font-size:13px;color:var(--mut);margin:16px 0 30px}
.field label{display:block;font-weight:600;font-size:14px;margin-bottom:10px;color:var(--text)}
.field input,.field select{width:100%;height:56px;border:1px solid var(--border);border-radius:14px;padding:0 16px;font-size:17px;font-family:inherit;background:#202024;color:#fff}
.field select{appearance:none;background:#202024 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='9' viewBox='0 0 14 9'%3E%3Cpath d='M1 1l6 6 6-6' fill='none' stroke='%23a1a1aa' stroke-width='2'/%3E%3C/svg%3E") no-repeat right 20px center}
.field select:disabled{background-color:#141416;color:#52525b;cursor:not-allowed}
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px}
.hide{display:none}

/* Kết quả */
#result{max-width:1200px;margin-top:28px}
.res{display:grid;grid-template-columns:1fr 56px 1fr;gap:18px;align-items:stretch}
.card{border:1px solid var(--border);border-radius:20px;padding:24px 28px;word-break:break-word;background:#202024}
.card.new{border-color:rgba(255,59,48,0.5);background:linear-gradient(145deg, #202024 0%, #2a1518 100%)}
.card small{font-size:11px;font-weight:700;color:var(--mut);letter-spacing:1px;text-transform:uppercase}
.card .nm{font-size:20px;font-weight:600;line-height:1.4;margin:8px 0 6px;color:#fff}
.arrow{align-self:center;width:56px;height:56px;border-radius:50%;background:#202024;border:1px solid var(--border);color:var(--red);display:grid;place-items:center;font-size:22px}
.tag{display:inline-block;font-size:12px;font-weight:600;padding:4px 12px;border-radius:20px;background:rgba(40,167,69,0.15);color:#2ecc71;margin:6px 6px 0 0;border:1px solid rgba(46,204,113,0.3)}
.tag.warn{background:rgba(255,193,7,0.15);color:#f1c40f;border-color:rgba(241,196,15,0.3)}
.tag.keep{background:rgba(108,117,125,0.15);color:#adb5bd;border-color:rgba(173,181,189,0.3)}
.members{margin-top:12px}.members span{display:inline-block;border:1px solid var(--border);background:#18181b;border-radius:20px;padding:3px 12px;margin:3px 4px 3px 0;font-size:13px;color:var(--mut)}
.members span.me{background:var(--red);border-color:var(--red);color:#fff}
.codes{display:flex;flex-wrap:wrap;gap:8px 24px;margin-top:14px;font-size:13px;color:var(--mut)}
.codes b{color:#fff}
.info{margin-top:18px;padding:16px 20px;border-radius:14px;background:#202024;border:1px solid var(--border);font-size:14px;line-height:1.7;color:var(--mut)}
.err{padding:16px 20px;border:1px solid rgba(255,59,48,0.4);background:rgba(255,59,48,0.1);color:#ff6b6b;border-radius:14px}
.cands{margin:10px 0 0;padding-left:20px}.cands li{margin:5px 0}
.link{background:none;border:0;color:var(--red);cursor:pointer;font-family:inherit;font-size:inherit;text-decoration:underline;padding:0}
.note{margin-top:36px;color:#71717a;font-size:13px;line-height:1.7;max-width:1200px}
.note a{color:var(--red);text-decoration:none}
@media(max-width:860px){h1{font-size:30px}.grid3{grid-template-columns:1fr}.res{grid-template-columns:1fr}.arrow{margin:auto;transform:rotate(90deg)}.tab{font-size:15px;padding:20px 12px 16px}}
</style>
</head>
<body>
<div class="wrap">
  <h1>Chuyển đổi địa chỉ cũ sang mới</h1>
  <p class="sub">Gõ tự do hoặc chọn theo danh sách. Kết quả gồm địa chỉ mới, mã hành chính và căn cứ sáp nhập.</p>

  <div class="panel">
    <div class="tabs">
      <button class="tab on" data-t="free">Gõ tự do</button>
      <button class="tab" data-t="list">Chọn theo danh sách</button>
    </div>

    <!-- Gõ tự do -->
    <div class="body" id="pane-free">
      <div class="search">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="text" maxlength="300" placeholder="Gõ tên phường/xã, quận/huyện, tỉnh cũ..." autocomplete="off">
        <button class="btn" id="goFree">Chuyển đổi <span>→</span></button>
      </div>
      <p class="hint">Có thể gõ không dấu và viết tắt: p.12, q.go vap, tphcm.</p>
      <div class="field">
        <label for="street1">Số nhà, tên đường (không bắt buộc — giữ nguyên sau chuyển đổi)</label>
        <input id="street1" maxlength="150">
      </div>
    </div>

    <!-- Chọn theo danh sách -->
    <div class="body hide" id="pane-list">
      <div class="grid3">
        <div class="field"><label for="selP">Tỉnh/Thành phố (cũ)</label><select id="selP"><option value="">— Chọn —</option></select></div>
        <div class="field"><label for="selD">Quận/Huyện (cũ)</label><select id="selD" disabled><option value="">— Chọn —</option></select></div>
        <div class="field"><label for="selW">Phường/Xã (cũ)</label><select id="selW" disabled><option value="">— Chọn —</option></select></div>
      </div>
      <div class="field">
        <label for="street2">Số nhà, tên đường (không bắt buộc — giữ nguyên sau chuyển đổi)</label>
        <input id="street2" maxlength="150">
      </div>
      <button class="btn big" id="goList"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3l4 4-4 4M21 7H8M7 21l-4-4 4-4M3 17h13"/></svg> Tiếp tục</button>
    </div>
  </div>

  <div id="result"></div>

  <p class="note">Nguồn dữ liệu: <a href="https://tinhthanhpho.com/api-docs" target="_blank" rel="noopener">tinhthanhpho.com</a> (CC BY 4.0).
  Kết quả mang tính tham khảo, hãy đối chiếu văn bản chính thức khi làm thủ tục.</p>
</div>

<script>
const $ = id => document.getElementById(id);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const norm = s => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/đ/g,'d').replace(/[^a-z0-9]+/g,' ').trim();
const stripPrefix = s => s.replace(/^(thanh pho|tinh|tp)\s+/,'');
const ALIAS = {'79':['sai gon','saigon','hcm','tphcm','tp hcm','ho chi minh'],'77':['vung tau','ba ria','brvt'],'01':['hn','thu do']};
const api = (q, opt) => fetch(q, opt).then(r => r.json());
const showErr = m => $('result').innerHTML = `<div class="err">${esc(m)}</div>`;
const label = x => (x.type ? x.type + ' ' : '') + x.name;
let PROV = [];

/* ---- Tab switching ---- */
document.querySelectorAll('.tab').forEach(b => b.onclick = () => {
  document.querySelectorAll('.tab').forEach(x => x.classList.toggle('on', x === b));
  $('pane-free').classList.toggle('hide', b.dataset.t !== 'free');
  $('pane-list').classList.toggle('hide', b.dataset.t !== 'list');$('result').innerHTML = '';
});

/* ---- Load data ---- */
function fill(sel, items, disabled) {
  sel.innerHTML = '<option value="">— Chọn —</option>' + items.map(x => `<option value="${esc(x.code)}">${esc(label(x))}</option>`).join('');
  sel.disabled = disabled ?? !items.length;
}
api('?action=provinces').then(r => {
  if (!r.ok) return showErr(r.message);
  PROV = r.data.map(p => ({...p, key: stripPrefix(norm(p.name)) + ' ' + (ALIAS[p.code] || []).join(' ')}));
  fill($('selP'), PROV, false);
}).catch(() => showErr('Không kết nối được máy chủ PHP.'));

$('selP').onchange = async () => {
  fill($('selD'), [], true); fill($('selW'), [], true);
  if (!$('selP').value) return;
  $('selD').innerHTML = '<option>Đang tải…</option>';
  const r = await api('?action=districts&code=' + $('selP').value);
  r.ok ? fill($('selD'), r.data) : (fill($('selD'), [], true), showErr(r.message));
};
$('selD').onchange = async () => {
  fill($('selW'), [], true);
  if (!$('selD').value) return;
  $('selW').innerHTML = '<option>Đang tải…</option>';
  const r = await api('?action=wards&code=' + $('selD').value);
  r.ok ? fill($('selW'), r.data) : (fill($('selW'), [], true), showErr(r.message));
};

/* ---- Render Results ---- */
const candText = c => typeof c === 'string' ? c : (c.fullAddress || c.address || c.name || Object.values(c).filter(v => typeof v === 'string').join(', '));

function showConvert(d) {
  const ok = d.confidence === 'exact';
  const cands = (d.candidates || []).map(c => `<li>${esc(candText(c))}</li>`).join('');
  const np = d.new?.province, nw = d.new?.ward;
  $('result').innerHTML = `<div class="res">
    <div class="card"><small>Địa chỉ cũ</small><div class="nm">${esc(d.old?.fullAddress)}</div></div>
    <div class="arrow">→</div>
    <div class="card new"><small>Địa chỉ mới</small><div class="nm">${esc(d.new?.fullAddress)}</div>
      <span class="tag ${ok ? '' : 'warn'}">${ok ? 'Chính xác' : 'Cần kiểm tra'}</span>
      <div class="codes">
        ${np ? `<span>Mã tỉnh/thành: <b>${esc(np.code)}</b></span>` : ''}
        ${nw ? `<span>Mã xã/phường: <b>${esc(nw.code)}</b></span>` : ''}
      </div></div></div>
    ${d.mergeInfo?.notes ? `<div class="info">${esc(d.mergeInfo.notes)}${d.mergeInfo.legal ? `<br><small>Căn cứ pháp lý: <b>${esc(d.mergeInfo.legal)}</b></small>` : ''}</div>` : ''}
    ${cands ? `<div class="info">Địa chỉ này có thể thuộc các đơn vị mới sau:<ul class="cands">${cands}</ul></div>` : ''}`;
}

function showProvince(r, oldP) {
  const n = r.new, merged = r.members.length > 1;
  $('result').innerHTML = `<div class="res">
    <div class="card"><small>Trước sáp nhập</small><div class="nm">${esc(label(oldP))}</div></div>
    <div class="arrow">→</div>
    <div class="card new"><small>Sau sáp nhập</small><div class="nm">${esc(label(n))}</div>
      <span class="tag ${merged ? '' : 'keep'}">${merged ? 'Sáp nhập từ ' + r.members.length + ' đơn vị' : 'Giữ nguyên tên và địa giới'}</span>
      ${merged ? `<div class="members">Gồm: ${r.members.map(m => `<span class="${m === oldP.name ? 'me' : ''}">${esc(m)}</span>`).join('')}</div>` : ''}
      <div class="codes">
        ${n.code ? `<span>Mã tỉnh/thành: <b>${esc(n.code)}</b></span>` : ''}
        ${n.hq ? `<span>Trụ sở: <b>${esc(n.hq)}</b></span>` : ''}
        ${n.area ? `<span>Diện tích: <b>${Number(n.area).toLocaleString('vi-VN')} km²</b></span>` : ''}
        ${n.pop ? `<span>Dân số: <b>${Number(n.pop).toLocaleString('vi-VN')}</b></span>` : ''}
      </div></div></div>
    ${n.legal ? `<div class="info">Căn cứ pháp lý: <b>${esc(n.legal)}</b></div>` : ''}`;
}

async function lookupProvince(p) {
  $('result').innerHTML = '<div class="info">Đang tra cứu…</div>';
  const r = await api('?action=province&code=' + encodeURIComponent(p.code));
  r.ok ? showProvince(r, p) : showErr(r.message);
}

async function convert(body, btn) {
  btn.disabled = true; $('result').innerHTML = '<div class="info">Đang chuyển đổi…</div>';
  try {
    const r = await api('?action=convert', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(body)});
    if (r.ok) return showConvert(r.data);
    const sg = (r.suggestions || []).map(s => {
      const t = candText(s);
      return `<li>${typeof s === 'string' ? `<button class="link" data-s="${esc(t)}">${esc(t)}</button>` : esc(t)}</li>`;
    }).join('');
    $('result').innerHTML = `<div class="err">${esc(r.message)}${sg ? `<div style="margin-top:8px">Có phải bạn muốn tìm:</div><ul class="cands">${sg}</ul>` : ''}</div>`;
    $('result').querySelectorAll('[data-s]').forEach(b => b.onclick = () => { $('text').value = b.dataset.s; $('goFree').click(); });
  } catch (e) { showErr('Không kết nối được máy chủ PHP.'); }
  finally { btn.disabled = false; }
}

$('goFree').onclick = () => {
  const text = $('text').value.trim();
  if (!text) return $('text').focus();
  const n = stripPrefix(norm(text)), street = $('street1').value.trim();
  const p = !street && PROV.find(x => stripPrefix(norm(x.name)) === n || (ALIAS[x.code] || []).includes(n));
  if (p) return lookupProvince(p);
  convert({text, streetAddress: street}, $('goFree'));
};
$('text').addEventListener('keydown', e => { if (e.key === 'Enter')$('goFree').click(); });

$('goList').onclick = () => {
  const pv = $('selP').value, dv = $('selD').value, wv =$('selW').value;
  if (!pv) return showErr('Hãy chọn Tỉnh/Thành phố (cũ).');
  if (!wv) {
    if (dv) return showErr('Hãy chọn thêm Phường/Xã (cũ) để chuyển đổi địa chỉ chi tiết.');
    return lookupProvince(PROV.find(x => x.code === pv));
  }
  convert({provinceCode: pv, districtCode: dv, wardCode: wv, streetAddress: $('street2').value.trim()},$('goList'));
};
</script>
</body>
</html>