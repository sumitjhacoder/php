require_once($_SERVER['DOCUMENT_ROOT'].'/app121/class/main.php');
include_once($_SERVER['DOCUMENT_ROOT'] .'/inc/config.php');
error_reporting(0);

function downloadFile($path, $contentType = 'application/octet-stream')
{
    ignore_user_abort(true);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="' .
    basename($path) . "\";");
    header("Content-Type: $contentType");

    $res = array(
        'status' =>false,
        'errors' =>array(),
        'readfileStatus' =>null,
        'aborted' =>false
    );

    $res['readfileStatus'] = readfile($path);
    if ($res['readfileStatus'] === false) {
        $res['errors'][] = 'readfile failed.';
        $res['status'] = false;
    }

    if (connection_aborted()) {
        $res['errors'][] = 'Connection aborted.';
        $res['aborted'] = true;
        $res['status'] = false;
    }

    return $res;
}

if (isset($_GET['file']) && $_GET['file'] != '') {
    $file = $_GET['file'];
    downloadFile($file);
}
