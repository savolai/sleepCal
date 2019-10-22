<!DOCTYPE html><html lang="en-us"><head><meta charset="utf-8">
<?php $text=highlight_file("core_source.php",true);
echo str_replace("&nbsp;"," ",$text);
highlight_string("</body></html>");
?>
