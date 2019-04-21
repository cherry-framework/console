<?php

require __DIR__ . '/../vendor/autoload.php';

use Cherry\Console\Output\Output;

$out = new Output();

echo $out->text('Text');
echo $out->info('Info');
echo $out->success('Success');
echo $out->warning('Warning');
echo $out->danger('Danger');
