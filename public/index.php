<?php
function getBody($html)
{
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    $bodies = $dom->getElementsByTagName('body');
    assert($bodies->length === 1);
    $body = $bodies->item(0);
    for ($i = 0; $i < $body->children->length; $i++) {
        $body->remove($body->children->item($i));
    }
    $stringbody = $dom->saveHTML($body);
    return $stringbody;
}

function phpinfo_html()
{
    ob_start();
    phpinfo();
    return getBody(ob_get_clean());
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP INFO</title>
  <style>
    body {
      background-color: #fff;
      color: #222;
      font-family: sans-serif;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    pre {
      margin: 0;
      font-family: monospace;
    }

    a:link {
      color: #009;
      text-decoration: none;
      background-color: #fff;
    }

    a:hover {
      text-decoration: underline;
    }

    table {
      border-collapse: collapse;
      border: 0;
      width: 934px;
      box-shadow: 1px 2px 3px #ccc;
    }

    .center {
      text-align: center;
    }

    .center table {
      margin: 1em auto;
      text-align: left;
    }

    .center th {
      text-align: center !important;
    }

    td, th {
      border: 1px solid #666;
      font-size: 75%;
      vertical-align: baseline;
      padding: 4px 5px;
    }

    th {
      position: sticky;
      top: 0;
      background: inherit;
    }

    h1 {
      font-size: 150%;
    }

    h2 {
      font-size: 125%;
    }

    .p {
      text-align: left;
    }

    .e {
      background-color: #ccf;
      width: 300px;
      font-weight: bold;
    }

    .h {
      background-color: #99c;
      font-weight: bold;
    }

    .v {
      background-color: #ddd;
      max-width: 300px;
      overflow-x: auto;
      word-wrap: break-word;
    }

    .v i {
      color: #999;
    }

    .info img {
      float: right;
      border: 0;
    }

    hr {
      width: 934px;
      background-color: #ccc;
      border: 0;
      height: 1px;
    } </style>
</head>
<body>
<div class="center">
  <img src="docker_stack_banner.jpg" alt="Docker Stack">
</div>
<div class="info">
    <?php echo phpinfo_html() ?>
</div>
</body>
</html>
