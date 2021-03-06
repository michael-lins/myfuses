<?php if (isset($_SESSION['file_message'])) { ?>
<br><br><font color="red"><?=$_SESSION['file_message']?></font>
<?php }
unset($_SESSION['file_message']);
?>

<h2>MyFuses Cache Listing</h2>

<?php
$cachedPath = $application->getController()->getParsedPath() . 
    $application->getName();
?>
<h3>Current Path: <?php echo $cachedPath?>
    <a href="<?=MyFuses::getMySelfXfa("deletePath", true, false) .
    "application=" . $application->getName() . "&file=" . urlencode($cachedPath)
    ?>">delete</a>
</h3>

<?php
$it = new RecursiveDirectoryIterator($cachedPath);

$depth = count(explode(DIRECTORY_SEPARATOR, $it->getPath()));

// RecursiveIteratorIterator accepts the following modes:
//     LEAVES_ONLY = 0  (default)
//     SELF_FIRST  = 1
//     CHILD_FIRST = 2

foreach (new RecursiveIteratorIterator($it, 1) as $path) {

    //var_dump($path->getFileName());
    if ($path->getFileName() != "." && $path->getFileName() != "..") {
        $iDepth = 0;
        if ($path->isDir()) {
            $iDepth = count(explode(DIRECTORY_SEPARATOR, $path));
            echo str_repeat("-", $iDepth - $depth) . "Path: $path <a href=\"" .
                MyFuses::getMySelfXfa("deletePath", true, false) . "application=" .
                $application->getName() . "&file=" . urlencode( $path ) .
                "\">delete</a><br>";
        } else {
            $iDepth = count(explode(DIRECTORY_SEPARATOR, $path->getPath())) + 1;
            echo str_repeat("-", $iDepth - $depth) . "File: $path <a href=\"" .
                MyFuses::getMySelfXfa("deletePath", true, false) . "application=" .
                $application->getName() . "&file=" . urlencode( $path ) .
                "\">delete</a><br>";
        }
    }
}
