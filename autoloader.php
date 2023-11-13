<?php

function fqcnToPath(string $fqcn): array|string
{
  return str_replace('\\', '/', $fqcn) . '.php';
}

spl_autoload_register(function (string $class) {
  $path = fqcnToPath($class);

  require PROJECT_ROOT_PATH . '/src/' . $path;
});
