<?php
header('Access-Control-Allow-Origin: *');
const ARR_CONTEXT_OPTIONS = array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

const URL = 'http://rentcafe.com/rentcafeapi.aspx?requestType=apartmentavailability&APIToken=NDY5OTI%3d-XDY6KCjhwhg%3d&propertyCode=p0155985 ';
const CACHE = __DIR__."/json.cache";
const REFRESH_TIME = 60*10;

function needs_updating() {
  return (time() - filectime(CACHE)) > (REFRESH_TIME) || 0 == filesize(CACHE);
}

function write_cache() {
  $result = file_get_contents(URL, false, stream_context_create(ARR_CONTEXT_OPTIONS));
  if ($result) {
    $handle_cache_file = fopen(CACHE, 'w+');
    fwrite($handle_cache_file, $result);
    fclose($handle_cache_file);
  }
}

if (needs_updating()) {
  write_cache();
}

echo file_get_contents(CACHE);
?>
