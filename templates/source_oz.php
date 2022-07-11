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
        0=>'Қарз шартномаси далолатномаси',
        1=>'Қарзни қисманқайтариш бўйича далолатнома',
        2=>'Қарзни тўлиқ қайтариш бўйича далолатнома',
        3=>'Қарз муддатини узайтириш бўйича далолатнома',
        4=>'Қарздан тўлиқ вос кечиш бўйича далолатнома',
        5=>'Қарздан қисман вос кечиш бўйича далолатнома',
        6=>'Қарзни узайтириш (дебитор)',
        7=>'Қарзмни қайтаришни талаб қилиш',
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

    <p style="text-align: center; font-weight: unset; font-size: 18px"><b><?= $json['contract']['number']?></b> - сонли қарз шартномаси бўйича</p>

    <h2 style="text-align: center" id="__mpdfinternallink_1">ЙИҒМА ЖИЛД</h2>
    <table class="toptable" style="width:90%">
        <tr>
            <td>Қарз берувчи:</td>
            <td><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></td>
        </tr>
        <tr>
            <td>Қарз олувчи:</td>
            <td><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></td>
        </tr>
        <tr>
            <td>Қа:</td>
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


    <p style="text-align: center; display: block; width:85%; font-weight: bold; position: absolute; bottom:80px; font-size: 18px; ">Zerox dasturi – 2022 yil</p>
    <pagebreak/>
    <p style="text-align: center; font-weight: unset; font-size: 18px; margin: 30px 0 20px 0"><b><?= $json['contract']['number']?></b> - sonli qarz shartnomasi mundarijasi</p>

    <table class="hisobot" style="width: 100%">
        <tr>
            <th>№</th>
            <th>Hujjat turi</th>
            <th>Varog`i</th>
        </tr>
        <tr>
            <td style="text-align: center">1</td>
            <td>Qarz shartnomasi</td>
            <td style="text-align: center">3</td>
        </tr>
        <?php $n=0; foreach ($acts as $item):$n++;?>
        <tr>
            <td style="text-align: center"><?= $n+1?></td>
            <td><?= $types[$lang][$item['type']]?></td>
            <td style="text-align: center"><?= $n + 4?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td style="text-align: center"><?= $n+2?></td>
            <td>Hisobot</td>
            <td style="text-align: center"><?= $n+5?></td>
        </tr>
    </table>

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
        <div class="content-title" style="font-size: 18px; margin-bottom:10px;">
            QARZ SHARTNOMASI №<?= $json['contract']['number'] ?>
        </div>
        <div class="content-body">
            <p>
                <b><?= $debitor['first_name'].' '.$debitor['last_name'].' '.$debitor['middle_name'] ?></b> (pasport:
                <b><?= $debitor['passport'] ?> <?= $debitor['issued_date'] ?></b> yilda
                <b><?= $debitor['issued_by'] ?></b> IIB tomonidan berilgan)
                (keyingi o`rinlarda “qarz beruvchi”) birinchi tomondan,
                <b><?= $creditor['first_name'].' '.$creditor['last_name'].' '.$creditor['middle_name'] ?></b> (pasport:
                <b><?= $creditor['passport'] ?> <?= $creditor['issued_date'] ?></b> yilda
                <b><?= $creditor['issued_by'] ?></b> (keyingi o`rinlarda “qarz oluvchi”) ikkinichi tomondan hamda “Infinity payment system” MCHJ (STIR(INN): 309053853) (keyingi o`rinlarda “Jamiyat”) uchinchi tomondan ushbu shartnomani quyidagilar haqida tuzdilar
            </p>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            1. Shartnoma predmeti
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        1.1.Qarz beruvchi mazkur shartnomaning shartlariga muvofiq qarz oluvchiga
                        <b><?= $json['contract']['amount'] ?> (<?= convertNumberToWord($json['contract']['amount'],$lang) ?>) </b>
                        <?= $json['contract']['currency']?>
                        miqdorida pul mablag`ini foizsiz qarzga beradi, qarz oluvchi esa o`z zimmasiga mazkur mablag`ni qaytarish majburiyatini oladi
                    </p>
                </li>
                <li>
                    <p>
                        1.2.Mazkur shartnomaning 1.1-bandida qayd etilgan miqdoridagi qarz summasi qarz oluvchi tomonidan qarz beruvchiga qismlarga bo`lib qaytarilishi mumkin;
                    </p>
                </li>
                <li>
                    <p>
                        1.3.Qarzning to`liq miqdori<b><?= date('d.m.Y',strtotime($json['contract']['end_date'])) ?></b>
                        yilga qadar qaytarilishi shart.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            2.Tomonlarning huquq va majburiyatlari
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        2.1.Qarz beruvchi mazkur shartnoma imzolangan kundan boshlab 1 kun muddat ichida shartnomaning 1.1-bandida ko`rsatilgan miqdordagi pul mablag`ini
                        naqd yoki naqdsiz shaklda qarz oluvchiga dalolatnoma asosiyda taqdim etadi; Dalolatnomaga u tuzilgan sana, taraflarning rekvizitlari,
                        qarz oluvchiga pul mablag`i taqdim etilgan sana va boshqa ma`lumotlar ko`rsatiladi.
                        Ushbu dalolatnoma tomonlar tomonidan mahsus elektron imzo (keyingi o`rinlarda "imzo") bilan imzolangandan so`ng mazkur qarz shartnomasining ajralmas qismi hisoblanadi.
                    </p>
                </li>
                <li>
                    <p>
                        2.2.Qarz oluvchi olgan qarz summasini mazkur shartnomaning 1.3-bandida nazarda tutilgan muddatga qadar qarz beruvchiga qaytaradi;
                    </p>
                </li>
                <li>
                    <p>
                        2.3.Qarz beruvchi qarz oluvchidan shartnoma bo`yicha berilgan qarz summasini shartnomada kelishilgan muddatda avval talab qilishga, qarz shartnomasi muddatini uzaytirishga va qarzdan voz kechishga haqli;
                    </p>
                </li>
                <li>
                    <p>
                        2.4.Qarz oluvchi qarz beruvchi qarzni qaytarish haqida talab qo`yilgan kundan boshlab 1 oy (o`ttiz kun) mobaynida qarzni qaytarishi lozim.
                        Agar qarz oluvchi o`ttiz kunlik muddatda qarz beruvchiga qarzni qaytarmasa, qarz muddati buzilgan hisoblanadi va har bir kechiktirilgan kun uchun 3.1-bandida belgilangan tartibda penya to`laydi;
                    </p>
                </li>
                <li>
                    <p>
                        2.5.Qarz oluvchi qarz summasini muddatidan avval qarz beruvchiga qaytarishga va qarz shartnomasi muddatini uzayitish uchun so`rovnoma yuborishga haqli.
                    </p>
                </li>
                <li>
                    <p>
                        2.6.Tomonlar mazkur shartnomani elektron shaklda tasdiqlashganliklari bilan ular qarz shartnomasiga ma`lumotlar (foydalanuvchining statusi, debitor va kreditor qarzdorliklarining jami summasi hamda muddati o`tgan  qarzdorliklarning summasi)ning uchinchi shaxslarga berilishiga rozilik bildirishganligini anglatadi.
                        Bunda Jamiyat tomonidan tomonlarning shaxsga oid ma`lumotlar uchinchi shaxslarga taqdim qilinmaydi.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            3.Tomonlarning javobgarligi
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        3.1. Qarz oluvchi ushbu shartnomaning 1.3-bandida nazarda tutilgan muddatga qadar qarz beruvchiga qarzni qaytarmasa, har bir kechiktirilgan kun uchun 0,5 (yarim) foiz, lekin qarz summasining 50(ellik) foizidan ortiq bo`lmagan miqdorda pernya to`laydi.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            4. Shartnomaning boshqa shartlari
        </div>
        <div class="content-body">
            <ul>
                <li>
                    <p>
                        4.1. Mazkur shartnoma qarz beruvchi va qarz oluvchi tomonidan "ZeroX" dasturi orqali elektron tarzda tuziladi va Imzo bilan tasdiqlanadi.

                    </p>
                </li>
                <li>
                    <p>
                        4.2. "ZeroX" dasturidan foydalanish bo`yicha tuzilgan "Universal shartnoma"ning 1.1-bandiga asosan birinchi va ikkinchi tomonlar shartnomani o`zlariga individual tarzda berilgan mahsus elektron imzo bilan imzolanishiga roziligini bildiradi hamda mahsus elektron imzo qo`lda qo`yilgan imzo bilan bir xil ahamiyatga ega ekanligini zimmasiga oladi.
                    </p>
                </li>
                <li>
                    <p>
                        4.3. Shartnoma tomonlar imzolagan vaqtdan boshlab kuchga kiradi va
                        <b><?= date('d.m.Y',strtotime($json['contract']['end_date']))?></b>
                        yilga qadar amal qiladi.
                    </p>
                </li>
                <li>
                    <p>
                        4.4. Qarz oluvchi qarz summasini muddatidan avval qarz beruvchiga qaytargan taqdirda qarz summasi qarz beruvchi tomonidan qabul qilinib olinganligi haqida dalolatnoma Imzo bilan imzolangan kundan shartnoma bekor bo`lishi mumkin.
                    </p>
                </li>
                <li>
                    <p>
                        4.5. Mazkur shartnoma va uning ajralmas qismi hisoblangan dalolatnomalar elektron tarzda tuziladi hamda ikki tomonning "ZeroX" dasturidagi shaxsiy kabinetida saqlanadi.
                    </p>
                </li>
                <li>
                    <p>
                        4.6. Qarz oluvchi va qarz beruvchi tomonidan Imzo bilan tasdiqlangan mazkur shartnomani va uning ajralmas qismi hisoblangan dalolatnomalarni "ZeroX" dasturidagi shaxsiy kabinetidan istalgan vaqtda ko`rib olishi hamda cho etishi mumkin.
                    </p>
                </li>
                <li>
                    <p>
                        4.7. Imzo bilan tasdiqlangan mazkur shartnoma va uning ajralmas qismi hisoblangan dalolatnomalarning saqlanishini Jamiyat o`z zimasiga oladi.
                    </p>
                </li>
                <li>
                    <p>
                        4.8.Mazkur shartnomaga kiritiladigan har qanday o`zgartirishlar tomonlarning roziligi asosida ko`shimcha shartnoma tuzish yo`li bilan amalga oshiriladi.
                    </p>
                </li>
                <li>
                    <p>
                        4.9.Shartnoma yuzasidan kelib chiqadigan nizolar tomonlarning o`zaro kelishuvi bilan hal etiladi.
                        Jamiyat shartnoma shartlari bajarilishini o`z zimmasiga olmaydi.
                        Tomonlar o`zaro kelishuvga erishmagan taqdirda nizo tegishli tartibda sud orqali hal etiladi.
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box qarz">
        <div class="content-title">
            5.Tomonlarning rekvizitlari
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


<?php $n=2; foreach ($acts as $act): $n++;?>

        <div class="box qarz" id="__mpdfinernallink_<?= $n?>">

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

    <pagebreak/>
<?php endforeach;?>

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


</body>
</html>