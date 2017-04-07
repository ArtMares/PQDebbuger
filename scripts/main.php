<?php

# QLocalServer QLocalSocket QIODevice QTabWidget QPlainTextEdit QWidget QString QRegExp
# QJsonDocument QJsonObject QJsonArray QJsonValue
# QScrollArea QFrame QVBoxLayout QHBoxLayout QGridLayout QSizePolicy QLabel

require_once 'ListWidget.php';
require_once 'Json.php';
require_once 'ObjectWidget.php';

$app = new QApplication($argc, $argv);

require_once 'PQDebugger.php';

$window = new PQDebugger();
$window->showMaximized();

return $app->exec();
