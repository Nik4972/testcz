<?php

require_once 'PHPExcel.php';
$pExcel = new PHPExcel();

$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();

// Ориентация страницы и  размер листа
$aSheet->getPageSetup()
        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$aSheet->getPageSetup()
        ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Поля документа
$aSheet->getPageMargins()->setTop(1);
$aSheet->getPageMargins()->setRight(0.75);
$aSheet->getPageMargins()->setLeft(0.75);
$aSheet->getPageMargins()->setBottom(1);
// Название листа
$aSheet->setTitle('Пользователи системы');
// Шапка и футер (при печати)
$aSheet->getHeaderFooter()
        ->setOddHeader('&ООО Бабай-Ка Ltd: пользователи системы');
$aSheet->getHeaderFooter()
        ->setOddFooter('&L&B' . $aSheet->getTitle() . '&RСтраница &P из &N');
// Настройки шрифта
$pExcel->getDefaultStyle()->getFont()->setName('Arial');
$pExcel->getDefaultStyle()->getFont()->setSize(8);


//Наполнение документа данными
//Для начала давайте зададим ширину столбцов (в символьных единицах), которые нам понадобятся: 

$aSheet->getColumnDimension('A')->setWidth(3);
$aSheet->getColumnDimension('B')->setWidth(20);
$aSheet->getColumnDimension('C')->setWidth(20);
$aSheet->getColumnDimension('D')->setWidth(20);
$aSheet->getColumnDimension('E')->setWidth(12);
$aSheet->getColumnDimension('F')->setWidth(20);
$aSheet->getColumnDimension('G')->setWidth(20);
$aSheet->getColumnDimension('H')->setWidth(20);
$aSheet->getColumnDimension('I')->setWidth(20);
$aSheet->getColumnDimension('J')->setWidth(20);
$aSheet->getColumnDimension('K')->setWidth(20);
//Теперь заполним несколько ячеек текстом:

$aSheet->mergeCells('A1:K1');
$aSheet->getRowDimension('1')->setRowHeight(20);
$aSheet->setCellValue('A1', 'ООО Бабай-Ка Ltd');
$aSheet->mergeCells('A2:K2');
$aSheet->setCellValue('A2', 'Зарегистрированные пользователи системы');
$aSheet->mergeCells('A4:K4');
$aSheet->setCellValue('A4', 'Дата создания отчета: ' . date('d-m-Y H:i:s'));

//Соединение с БД
require_once ('connect.php');

$link = connect_db();
$link->set_charset("utf8");

if ($link->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
}

// Создаем шапку таблички данных
$aSheet->setCellValue('A6', '№');
$aSheet->setCellValue('B6', 'Фамилия');
$aSheet->setCellValue('C6', 'Имя');
$aSheet->setCellValue('D6', 'Отчество');
$aSheet->setCellValue('E6', 'ДР');
$aSheet->setCellValue('F6', 'E-Mail');
$aSheet->setCellValue('G6', 'Логин');
$aSheet->setCellValue('H6', 'Пароль');
$aSheet->setCellValue('I6', 'Карта №');
$aSheet->setCellValue('J6', 'Регистрация');
$aSheet->setCellValue('K6', 'Сумма покупок');

// Вывод БД Users если ввели логин: admin  пароль: admin

if (!($query = $link->prepare("SELECT u.fam, u.name, u.name2, u.dr, u.email, u.username, u.password, c.name as cardname, u.created_at, (select sum(summa) from trash WHERE userid=u.id) as summa FROM users u LEFT JOIN cards c ON c.id = u.card_id WHERE u.username <> 'admin' ORDER BY summa DESC"))) {
    echo "Не удалось подготовить запрос: (" . $link->errno . ") " . $link->error;
}

if (!$query->execute()) {
    echo "Не удалось выполнить запрос: (" . $query->errno . ") " . $query->error;
}


$query->store_result();
$row = $query->num_rows;

if ($row === 0) {
    die('<body bgcolor=black text=red><div align="center"><h1>Неверное имя пользователя или пароль!</h1></div></body>' . mysqli_error());
}

$query->bind_result($fam, $name, $name2, $dr, $email, $username, $password, $cardname, $created_at, $summa);
$i = 1;

while ($query->fetch()) {
    $aSheet->setCellValue('A' . ($i + 6), $i);
    $aSheet->setCellValue('B' . ($i + 6), $fam);
    $aSheet->setCellValue('C' . ($i + 6), $name);
    $aSheet->setCellValue('D' . ($i + 6), $name2);
    $aSheet->setCellValue('E' . ($i + 6), $dr);
    $aSheet->setCellValue('F' . ($i + 6), $email);
    $aSheet->setCellValue('G' . ($i + 6), $username);
    $aSheet->setCellValue('H' . ($i + 6), $password);
    $aSheet->setCellValue('I' . ($i + 6), $cardname);
    $aSheet->setCellValue('J' . ($i + 6), date("d-m-Y H:i:s", strtotime($created_at)));
    $aSheet->setCellValue('K' . ($i + 6), $summa);


    $i++;
}

//Стилизация данных
// массив стилей
$style_wrap = array(
    // рамки
    'borders' => array(
        // внешняя рамка
        'outline'    => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array(
                'rgb' => '006464'
            )
        ),
        // внутренняя
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => 'CCCCCC'
            )
        )
    )
);

$aSheet->getStyle('A1:K' . ($i + 5))->applyFromArray($style_wrap);

// Стили для верхней надписи (первая строка)
$style_header = array(
    // Шрифт
    'font'      => array(
        'bold'  => true,
        'name'  => 'Times New Roman',
        'size'  => 15,
        'color' => array(
            'rgb' => '006464'
        )
    ),
    // Выравнивание
    'alignment' => array(
        'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
    ),
    // Заполнение цветом
    'fill'      => array(
        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
        'color' => array(
            'rgb' => '99CCCC'
        )
    ),
    'borders'   => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '006464'
            )
        )
    )
);
$aSheet->getStyle('A1:K1')->applyFromArray($style_header);

// Стили для слогана компании (вторая строка)
$style_slogan = array(
    // шрифт
    'font'      => array(
        'bold'   => true,
        'italic' => true,
        'name'   => 'Times New Roman',
        'size'   => 12,
        'color'  => array(
            'rgb' => '006464'
        )
    ),
    // выравнивание
    'alignment' => array(
        'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
        'vertical'   => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
    ),
    // заполнение цветом
    'fill'      => array(
        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
        'color' => array(
            'rgb' => '99CCCC'
        )
    ),
    //рамки
    'borders'   => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '006464'
            )
        )
    )
);
$aSheet->getStyle('A2:K2')->applyFromArray($style_slogan);

// Стили для текта возле даты
$style_tdate = array(
    // выравнивание
    'alignment' => array(
        'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
    ),
    // заполнение цветом
    'fill'      => array(
        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
        'color' => array(
            'rgb' => 'EEEEEE'
        )
    ),
    // рамки
    'borders'   => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK
        )
    )
);
$aSheet->getStyle('A4:K4')->applyFromArray($style_tdate);

// Стили для даты
$style_date = array(
    // заполнение цветом
    'fill'    => array(
        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
        'color' => array(
            'rgb' => 'EEEEEE'
        )
    ),
    // рамки
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    ),
);
$aSheet->getStyle('E5')->applyFromArray($style_date);

// Стили для шапки таблицы (шестая строка)
$style_hprice = array(
    // выравнивание
    'alignment' => array(
        'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
    ),
    // заполнение цветом
    'fill'      => array(
        'type'  => PHPExcel_STYLE_FILL::FILL_SOLID,
        'color' => array(
            'rgb' => 'CFCFCF'
        )
    ),
    // шрифт
    'font'      => array(
        'bold' => true,
        /* 'italic' => true, */
        'name' => 'Times New Roman',
        'size' => 10
    ),
);
$aSheet->getStyle('A6:K6')->applyFromArray($style_hprice);

// Cтили для данных в таблице прайс-листа
$style_price = array(
    'alignment' => array(
        'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
    )
);
$aSheet->getStyle('A7:K' . ($i + 5))->applyFromArray($style_price);

//Сохранение документа:
//Для простого сохранения вот так:
//$objWriter = PHPExcel_IOFactory::createWriter($pExcel, 'Excel2007');
//$objWriter->save('simple.xlsx');
//Для формирования файла  и показа его, вот так:
header('Content-Type:xlsx:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition:attachment;filename="simple.xlsx"');
$objWriter = new PHPExcel_Writer_Excel2007($pExcel);
$objWriter->save('php://output');
?>


