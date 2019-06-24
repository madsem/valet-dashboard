<?php
$valet_xdg_home = getenv('HOME') . '/.config/valet';
$valet_old_home = getenv('HOME') . '/.valet';
$valet_home_path = is_dir($valet_xdg_home) ? $valet_xdg_home : $valet_old_home;
$valet_config = json_decode(file_get_contents("$valet_home_path/config.json"));
$tld = isset($valet_config->tld) ? $valet_config->tld : $valet_config->domain;
?>
<html>
<title>Valet Dashboard</title>
<head>
    <script src="https://kit.fontawesome.com/ec0ad2db99.js"></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            justify-items: center;
        }
    </style>
</head>
<body class="m-12 font-mono">

<div class="flex mb-4">
    <div class="w-full text-gray-600 h-12">
        <a class="relative float-right"
           href="/info.php">
            <i class="fas fa-info-circle"></i>
            phpinfo();
        </a>
    </div>
</div>

<div class="grid">
    <?php foreach ($valet_config->paths as $parked_path) : ?>
        <div class="leading-normal whitespace-no-wrap">
            <code class="font-mono text-gray-600"><?= str_replace(getenv('HOME'), '~', $parked_path) ?></code>
            <ul class="list-decimal pl-4 text-gray-600">
                <?php foreach (scandir($parked_path) as $site) : ?>
                    <?php if ($site == basename(__DIR__)): continue; endif ?>
                    <?php if ((is_dir("$parked_path/$site") || is_link("$parked_path/$site")) && $site[0] != '.') : ?>
                        <li><a href="http://<?= "$site.$tld" ?>/" target="<?= "valet_$site" ?>"
                               class="text-blue-500 hover:text-blue-400 no-underline hover:underline"><?= "$site.$tld" ?></a>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endforeach ?>
</div>

</body>
</html>
