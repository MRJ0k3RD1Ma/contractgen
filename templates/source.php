<?php
require_once __DIR__ . '/../vendor/autoload.php';

    $id = $_GET['id'];
    $lang = strtolower($_GET['lang']);
    $json = $_GET['body'];

    $acts = $json['acts'];

    $debitor = $json['contract']['debitor'];
    $creditor = $json['contract']['creditor'];

    $types = [
        'uz'=>[
            0=>'Qarz shartnomasi dalolatnomasi',
            1=>'Qarzni qisman qaytarish bo`yicha dalolatnoma',
            2=>'Qarzni to`liq qaytarish bo`yicha dalolatnoma',
            3=>'Qarz muddatini uzaytirish bo`yicha dalolatnoma',
            4=>'Qarzdan to`liq vos kechish bo`yicha dalolatnoma',
            5=>'Qarzdan qisman vos kechish bo`yicha dalolatnoma',
            6=>'Qarzni uzaytirish (debitor)',
            7=>'Qarzmni qaytarishni talab qilish',
        ],
        'oz'=>[
            0=>'Qarz shartnomasi dalolatnomasi',
            1=>'Qarzni qisman qaytarish bo`yicha dalolatnoma',
            2=>'Qarzni to`liq qaytarish bo`yicha dalolatnoma',
            3=>'Qarz muddatini uzaytirish bo`yicha dalolatnoma',
            4=>'Qarzdan to`liq vos kechish bo`yicha dalolatnoma',
            5=>'Qarzdan qisman vos kechish bo`yicha dalolatnoma',
            6=>'Qarzni uzaytirish (debitor)',
            7=>'Qarzmni qaytarishni talab qilish',
        ],
        'ru'=>[
            0=>'Qarz shartnomasi dalolatnomasi',
            1=>'Qarzni qisman qaytarish bo`yicha dalolatnoma',
            2=>'Qarzni to`liq qaytarish bo`yicha dalolatnoma',
            3=>'Qarz muddatini uzaytirish bo`yicha dalolatnoma',
            4=>'Qarzdan to`liq vos kechish bo`yicha dalolatnoma',
            5=>'Qarzdan qisman vos kechish bo`yicha dalolatnoma',
            6=>'Qarzni uzaytirish (debitor)',
            7=>'Qarzmni qaytarishni talab qilish',
        ]
    ];

    ?>
<?php
function convertNumberToWord($num = false,$lang = 'uz')
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    if($lang == 'oz'){
        $list1 = array('', 'бир', 'икки', 'уч', 'тўрт', 'беш', 'олти', 'етти', 'саккиз', 'тўққиз', 'ўн', 'ўн бир',
            'ўн икки', 'ўн уч', 'ўн тўрт', 'ўн беш', 'ўн олти', 'ўн етти', 'ўн саккиз', 'ўн тўққиз'
        );
        $list2 = array('', 'ўн', 'йигирма', 'ўтти', 'қирқ', 'эллик', 'олтмиш', 'етмиш', 'саксон', 'тўқсон', 'юз');
        $list3 = array('', 'минг', 'миллион', 'миллиард', 'триллион', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
    }elseif($lang == 'ru'){
        $list1 = array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять', 'десять', 'одиннадцать',
             'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'
         );
         $list2 = array('', 'десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто', 'лицо');
         $list3 = array('', 'тысяча', 'миллион', 'миллиард', 'триллион', 'квадриллион', 'квинтиллион', 'секстиллион', 'септиллион',
             'октиллион', 'нониллион', 'дециллион', 'ундециллион', 'дудециллион', 'тредециллион', 'кваттюордециллион',
             'квиндециллион', 'сексдециллион', 'септендециллион', 'октодециллион', 'новемдециллион', 'вигинтиллион'
         );
    }else{
        $list1 = array('', 'bir', 'ikki', 'uch', 'to`rt', 'besh', 'olti', 'yetti', 'sakkiz', 'to`qqiz', 'o`n', 'o`n bir',
            'o`n ikki', 'o`n uch', 'o`n to`rt', 'o`n besh', 'o`n olti', 'o`n yetti', 'o`n sakkiz', 'o`n to`qqiz'
        );
        $list2 = array('', 'o`n', 'yigirma', 'o`ttiz', 'qirq', 'ellik', 'oltmish', 'yetmish', 'sakson', 'to`qson', 'yuz');
        $list3 = array('', 'ming', 'million', 'milliard', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
    }



    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' yuz' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}



$url = __DIR__.'/res/zerox_logo_white.png';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


$qr =function($id) use ($url) {
    $data = Builder::create()
        ->writer(new PngWriter())

        ->data("#".$id)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(180)
        ->margin(3)

        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->foregroundColor(new Color(47,97,181))
        ->logoResizeToHeight(30)
        ->logoResizeToHeight(30)
        ->logoPath($url)
        ->logoPunchoutBackground(0)

        ->labelText('')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())

        ->build();

    return $data->getDataUri();
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div class="container">
    <table>
        <tr style="width: 100%">
            <td style="width: 50%">
                <img width="150px" src="<?= __DIR__?>/res/zeroX.png" alt="" /><br><br>
                <i style="color:#4E84E2">&nbsp;&nbsp;&nbsp; Ishonch kafolati</i>
            </td>
            <td style="width: 50%;">
                <?= "<img src='{$qr($id)}' style='margin-left:200px'>";?>

            </td>
        </tr>
    </table>

    <br>
    <br>
    <br>

    <p style="text-align: center; font-weight: unset; font-size: 18px"><b><?= $json['contract']['number']?></b> - sonli qarz shartnomasi bo'yicha</p>

    <h2 style="text-align: center">YIG'MA JILD</h2>
    <table class="table">
        <tr>
            <td>Qarz beruvchi:</td>
            <td><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></td>
        </tr>
        <tr>
            <td>Qarz oluvchi:</td>
            <td><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></td>

        </tr>
        <tr>
            <td>Qarz olingan sana:</td>
            <td><?= date('d.m.Y',strtotime($json['contract']['date'])) ?></td>

        </tr>
        <tr>
            <td>Qarz miqdori:</td>
            <td><?= $json['contract']['amount'].' '.$json['contract']['currency'] ?></td>
        </tr>
        <tr>
            <td>Qarz qaytarish sanasi:</td>
            <td><?= date('d.m.Y',strtotime($json['contract']['end_date'])) ?></td>
        </tr>
    </table>

    <p style="text-align: center; font-weight: unset; font-size: 18px"><b><?= $json['contract']['number']?></b> - sonli qarz shartnomasi mundarijasi</p>

    <table class="table" style="width: 100%">
        <tr>
            <th>№</th>
            <th>Hisobot turi</th>
            <th>Beti</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Qarz shartnomasi</td>
            <td>-</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Hisobot</td>
            <td>-</td>
        </tr>
    </table>
</div>
<pagebreak />

<div>
    <table>
        <tr style="width: 100%">
            <td style="width: 50%">
                <img width="150px" src="<?= __DIR__?>/res/zeroX.png" alt="" /><br><br>
                <i style="color:#4E84E2">&nbsp;&nbsp;&nbsp; Ishonch kafolati</i>
            </td>
            <td style="width: 50%;">
                <?= "<img src='{$qr($id)}' style='margin-left:200px'>";?>
            </td>
        </tr>
    </table>
    <div class="box qarz">
        <div class="content-title">
            <h3>QARZ SHARTNOMASI №<?= $json['contract']['number'] ?></h3>
        </div>
        <div class="content-body">
            <p>
                <b><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></b> (pasport:
                <b><?= $debitor['passport'] ?> <?= $debitor['issued_date'] ?></b> yilda
                <b><?= $debitor['issued_by'] ?></b> IIB tomonidan berilgan)
                (keyingi o'rinlarda “qarz beruvchi”) birinchi tomondan,
                <b><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></b> (pasport:
                <b><?= $creditor['passport'] ?> <?= $creditor['issued_date'] ?></b> yilda
                <b><?= $creditor['issued_by'] ?></b> IIB tomonidan berilgan)
                (keyingi o'rinlarda “qarz oluvchi”) ikkinichi tomondan hamda “Infinity payment
                system” MCHJ (STIR(INN): 309053853) (keyingi o'rinlarda
                “Jamiyat”) uchinchi tomondan ushbu shartnomani quyidagilar haqida tuzdilar
            </p>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            <h2>1. Shartnoma predmeti</h2>
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        1.1.Қарз берувчи мазкур шартноманинг шартларига
                        мувофиқ Қарз олувчига
                        <b><?= $json['contract']['amount'] ?> (<?= convertNumberToWord($json['contract']['amount'],$lang) ?>) </b>
                        сўм миқдорида пул маблағини фоизсиз қарзга
                        беради, Қарз олувчи эса ўз зиммасига мазкур
                        маблағни қайтариш мажбуриятини олади;
                    </p>
                </li>
                <li>
                    <p>
                        1.2.Мазкур шартноманинг 1.1-бандида қайд этилган
                        миқдордаги қарз суммаси Қарз олувчи томонидан
                        Қарз берувчига қисмларга бўлиб қайтарилиши
                        мумкин;
                    </p>
                </li>
                <li>
                    <p>
                        1.3.Қарзнинг тўлиқ миқдори <b><?= date('d.m.Y',strtotime($json['contract']['end_date'])) ?></b> йилга
                        қадар қайтарилиши шарт.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            <h2>2.Томонларнинг ҳуқуқ ва мажбуриятлари</h2>
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        2.1.Қарз берувчи мазкур шартнома имзоланган
                        кундан бошлаб 1 кун муддат ичида шартноманинг
                        1.1-бандида кўрсатилган миқдордаги пул маблағини
                        нақд ёки нақдсиз шаклда Қарз олувчига
                        далолатнома асосида тақдим этади; Далолатномада
                        у тузилган сана, тарафларнинг реквизитлари, Қарз
                        олувчига пул маблағи тақдим этилган сана ва
                        бошқа маълумотлар кўрсатилади. Ушбу далолатнома
                        Томонлар томонидан махсус электрон имзо (кейинги
                        ўринларда “Имзо”) билан имзолангандан сўнг
                        мазкур қарз шартномасининг ажралмас қисми
                        ҳисобланади.
                    </p>
                </li>
                <li>
                    <p>
                        2.2.Қарз олувчи олинган қарз суммасини мазкур
                        шартноманинг 1.3-бандида назарда тутилган
                        муддатга қадар Қарз берувчига қайтаради;
                    </p>
                </li>
                <li>
                    <p>
                        2.3.Қарз берувчи Қарз олувчидан шартнома бўйича
                        берилган қарз суммасини шартномада келишилган
                        муддатдан аввал талаб қилишга, қарз шартномаси
                        муддатини узайтиришга ва қарздан воз кечишга
                        ҳақли.
                    </p>
                </li>
                <li>
                    <p>
                        2.4.Қарз олувчи Қарз берувчи қарзни қайтариш
                        ҳақида талаб қўйган кундан бошлаб 1 ой (ўттиз
                        кун) мобайнида қарзни қайтариши лозим. Агар Қарз
                        олувчи ўттиз кунлик муддатда Қарз берувчига
                        қарзни қайтармаса, қарз муддати бузилган
                        ҳисобланади ва ҳар бир кечиктирилган кун учун
                        3.1-бандида белгиланган тартибда пеня тўлайди.
                    </p>
                </li>
                <li>
                    <p>
                        2.5.Қарз олувчи қарз суммасини муддатидан аввал
                        Қарз берувчига қайтаришга ва қарз шартномаси
                        муддатини узайтириш учун сўровнома юборишга
                        ҳақли.
                    </p>
                </li>
                <li>
                    <p>
                        2.6.Томонлар мазкур шартномани электрон шаклда
                        тасдиқлашганликлари билан улар қарз
                        шартномасидаги маълумотлар (фойдаланувчининг
                        статуси, дебитор ва кредитор қарздорликларининг
                        жами суммаси ҳамда муддати ўтган
                        қарздорликларининг суммаси) нинг учинчи
                        шахсларга берилишига розилик билдиришганлигини
                        англатади. Бунда Жамият томонидан томонларнинг
                        шахсига оид маълумотлар учинчи шахсларга тақдим
                        қилинмайди.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            <h2>3.Томонларнинг жавобгарлиги</h2>
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        3.1.Қарз олувчи ушбу шартноманинг 1.3-бандида
                        назарда тутилган муддатга қадар Қарз берувчига
                        қарзни қайтармаса, ҳар бир кечиктирилган кун
                        учун 0,5 (ярим) фоиз, лекин қарз суммасининг 50
                        (эллик) фоизидан ортиқ бўлмаган миқдорда пеня
                        тўлайди.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            <h2>4.Шартноманинг бошқа шартлари</h2>
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        4.1.Мазкур шартнома Қарз берувчи ва Қарз олувчи
                        томонидан <b>“ZeroX”</b> дастури орқали электрон тарзда
                        тузилади ва Имзо билан тасдиқланади.
                    </p>
                </li>
                <li>
                    <p>
                        4.2.“ZeroX” дастуридан фойдаланиш бўйича
                        тузилган “Универсал шартнома”нинг 11-бандига
                        асосан биринчи ва иккинчи томонлар шартномани
                        ўзларига индивидуал тарзда берилган махсус
                        электрон имзо билан имзоланишига розилигини
                        билдиради ҳамда махсус электрон имзо қўлда
                        қўйилган имзо билан бир ҳил аҳамиятга эга
                        эканлигини зиммасига олади.
                    </p>
                </li>
                <li>
                    <p>
                        4.3.Шартнома томонлар имзоланган вақтдан бошлаб
                        кучга киради ва <b><?= date('d.m.Y',strtotime($json['contract']['end_date']))?></b> йилга
                        қадар амал қилади.
                    </p>
                </li>
                <li>
                    <p>
                        4.4.Қарз олувчи қарз суммасини муддатидан аввал
                        Қарз берувчига қайтарган тақдирда қарз суммаси
                        қарз берувчи томонидан қабул қилиб олинганлиги
                        ҳақида далолатнома Имзо билан имзоланган кундан
                        шартнома бекор бўлиши мумкин.
                    </p>
                </li>
                <li>
                    <p>
                        4.5.Мазкур шартнома ва унинг ажралмас қисми
                        ҳисобланган далолатномалар электрон тарзда
                        тузилади ҳамда икки томоннинг “ZeroX”
                        дастуридаги шахсий кабинетида сақланади.
                    </p>
                </li>
                <li>
                    <p>
                        4.6.Қарз олувчи ва Қарз берувчи томонидан Имзо
                        билан тасдиқланган мазкур шартномани ва унинг
                        ажралмас қисми ҳисобланган далолатномаларни
                        “ZeroX” дастуридаги шахсий кабинетидан исталган
                        вақтда кўчириб олиши ҳамда чоп этиши мумкин.
                    </p>
                </li>
                <li>
                    <p>
                        4.7.Имзо билан тасдиқланган мазкур шартнома ва
                        унинг ажралмас қисми ҳисобланган
                        далолатномаларнинг сақланишини Жамият ўз
                        зиммасига олади.
                    </p>
                </li>
                <li>
                    <p>
                        4.8.Мазкур шартномага киритиладиган ҳар қандай
                        ўзгартиришлар томонларнинг розилиги асосида
                        қўшимча шартнома тузиш йўли билан амалга
                        оширилади.
                    </p>
                </li>
                <li>
                    <p>
                        4.9.Шартнома юзасидан келиб чиқадиган низолар
                        томонларнинг ўзаро келишуви билан ҳал этилади.
                        Жамият шартнома шартлари бажарилишини ўз
                        зиммасига олмайди. Томонлар ўзаро келишувга
                        эришмаган тақдирда низо тегишли тартибда суд
                        орқали ҳал этилади.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            <h2>5.Томонларнинг реквизитлари</h2>
        </div>
        <div class="content-body">
            <table class="rektable">
                <tr>
                    <th>Qarz beruvchi(debitor)</th>
                    <th>Qarz oluvchi(kreditor)</th>
                </tr>
                <tr>
                    <td><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></td>
                    <td><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></td>
                </tr>
                <tr>
                    <td><?php $text = "Novidir text chiqishi garak"; echo "<img src='{$qr($text)}' style='float: left'>";?></td>
                    <td><?php $text = "Novidir text chiqishi garak"; echo "<img src='{$qr($text)}' style='float: right'>";?></td>
                </tr>
                <tr>
                    <td>Sana: <?= $json['contract']['date'] ?></td>
                    <td>Sana: <?= $json['contract']['date'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<pagebreak/>


    <?php foreach ($acts as $act):?>
<div class="container">
    <div class="box qarz">
        <div class="content-title">
            DALOLATNOMA
        </div>
        <div class="content-body">
            <p style="text-align: center;">(<b><?= $json['contract']['number'] ?></b>-sonli qarz shartnomasi bo'yicha qarz mablag'i olinganligi to'g'risida)</p>
            <p>
                Biz quyida imzo qo'yuvchilar,
                <b><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></b> (pasport:
                <b><?= $debitor['passport'] ?> <?= $debitor['issued_date'] ?></b> yilda
                <b><?= $debitor['issued_by'] ?></b> IIB tomonidan berilgan)
                bir tomondan va
                <b><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></b> (pasport:
                <b><?= $creditor['passport'] ?> <?= $creditor['issued_date'] ?></b> yilda
                <b><?= $creditor['issued_by'] ?></b> IIB tomonidan berilgan)
                ikkinichi tomondan ushbu dalolatnomani quyidagilar xaqida tuzdilar:
            </p>
            <p>
                <b><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></b> tomonidan
                <b><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></b>ga

                <?= date('d.m.Y',strtotime($json['contract']['date'])) ?> yildagi <?= $json['contract']['number']?>-sonli qarz shartnomasiga asosan <b><?= $act['residual_amount']?> <?= $json['contract']['currency'] ?> miqdoridagi pul mablag'ini <?= date('d.m.Y',strtotime($act['end_date'])) ?> yilgacha</b> foizsiz qarz sifatida topshirildi.
            </p>
            <p>Mazkur dalolatnoma Imzo orqali tasdiqlangan xolda elektron tarzda tuzildi.</p>
            <p>Dalolatnoma ikki tomonning “ZeroX” dasturidagi shaxsiy kabinetida saqlanadi.</p>
            <p>Maxsus elektron imzo orqali tasdiqlangan dalolatnomaning saqlanishi jamiyat o'z zimmasiga oladi.</p>

            <table class="rektable">
                <tr>
                    <th>Qarz beruvchi(debitor)</th>
                    <th>Qarz oluvchi(kreditor)</th>
                </tr>
                <tr>
                    <td><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></td>
                    <td><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></td>
                </tr>
                <tr>
                    <td><?php $text = "Novidir text chiqishi garak"; echo "<img src='{$qr($text)}' style='float: left'>";?></td>
                    <td><?php $text = "Novidir text chiqishi garak"; echo "<img src='{$qr($text)}' style='float: right'>";?></td>
                </tr>
                <tr>
                    <td>Sana: <?= $json['contract']['date'] ?></td>
                    <td>Sana: <?= $json['contract']['date'] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
        <pagebreak/>
    <?php endforeach;?>

<div class="container">
    <div class="box qarz">
        <p style="text-align: center"><?= $json['contract']['number']?>-sonli qarz shartnomasi bo’yicha</p>
        <div class="content-title">
            HISOB-KITOB
        </div>
        <div class="content-body">

            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Hujjat turi</th>
                        <th>Rasmiylashtirilgan sana</th>
                        <th>Qarz miqdori</th>
                        <th>Qaytarilgan miqdor</th>
                        <th>Voz kechilgan miqdor</th>
                        <th>Qoldiq qarz miqdori</th>
                        <th>Qarzni qaytarish sanasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $qoldiq = 0; $n = 0; foreach ($acts as $act): $n++; $qoldiq = $act['residual_amount'];?>
                    <tr>
                        <td><?= $n?></td>
                        <td><?= $types[$lang][$act['type']] ?></td>
                        <td><?= date('d.m.Y',strtotime($act['createdAt']))?></td>
                        <td><?= $act['residual_amount'].' '.$json['contract']['currency'] ?></td>
                        <td><?= $act['inc']==0?'-':$act['inc'].' '.$json['contract']['currency'] ?></td>
                        <td><?= $act['vos_summa']==0?'-':$act['vos_summa'].' '.$json['contract']['currency'] ?></td>
                        <td><?= $act['residual_amount']==0?'-':$act['residual_amount'].' '.$json['contract']['currency'] ?></td>
                        <td><?= date('d.m.Y',strtotime($act['end_date'])) ?></td>
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="6" style="text-align: center">Qaytarilishi lozim bo'gan qarz miqdori:</td>
                        <td colspan="2" style="text-align: center"><?= $qoldiq.' '.$json['contract']['currency']?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>


</body>
</html>