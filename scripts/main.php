<?php

# QObject
# QIODevice
# QCursor
# QJsonObject QJsonDocument QJsonArray QJsonValue
# QLocalServer
# QLocalSocket
# QPaintDevice
# QWidget
# QTabWidget
# QFrame
# QAbstractScrollArea
# QPlainTextEdit
# QString
# QRegExp
# QScrollArea
# QLayoutItem
# QLayout
# QBoxLayout
# QVBoxLayout
# QHBoxLayout
# QGridLayout
# QSizePolicy
# QLabel
# QIcon
# QPixmap
# QCoreApplication
# QGuiApplication
# QApplication

//require_once 'ListWidget.php';
//require_once 'Json.php';
//require_once 'ObjectWidget.php';

spl_autoload_register(function($className) {
    $file = str_replace('\\', '/', $className).'.php';
    $qf = new QFile();
    $qf->setFileName(':/scripts/'.$file);
    if($qf->exists()) {
        require_once('qrc://scripts/'.$file);
        return true;
    } else {
        $qf->setFileName($file);
        if($qf->exists()) {
            require_once($file);
            return true;
        }
    }
    return false;
});


//require_once 'qrc://scripts/Tab.php';
//require_once 'qrc://scripts/ListWidget.php';
//require_once 'qrc://scripts/ObjectWidget.php';
//require_once 'qrc://scripts/Json.php';
//require_once 'qrc://scripts/Icon.php';

$app = new QApplication($argc, $argv);

//require_once 'PQDebugger.php';
//
//$window = new PQDebugger();
require_once 'qrc://scripts/PHPQt5Debugger.php';
$window = new PHPQt5Debugger();
$window->showMaximized();

$t = new \Widgets\Tab();

return $app->exec();
