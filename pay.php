<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

require_once ('incfiles/core.php');
require_once ('incfiles/head.php');

// Россия
if ($act == "ru")
{
echo '<div class="gmenu"><b>С помощью терминала (России)</b></div>';
echo '<div class="c">
Вы гражданин России? Тогда ета информация для Вас.<br/><br/>

При оплате через терминал следуйте экранному меню и будьте, пожалуйста, внимательны при вводе номера кошелька.<br/>
Прием средств терминалами обычно происходит следующим образом:<br/><br/>

- Выберите на сенсорном экране значок "WebMoney".<br/>
- Введите 12 цифр номера R-кошелька: <font color="#FF0000"><b>180456171439</b></font><br/>
- Терминал проверит правильность номера кошелька.<br/>
- Терминал попросит вставить купюры.<br/>
- Получите и сохраните чек.<br/>
- Готово.<br/><br/>

Напишите администратору о том когда и на какую сумму был перевод.<br/>
Обычно от часа до суток идет перевод и буцеры будут начислены.<br/>
</div>';

echo '<div class="c">
<a href="str/pradd.php?act=write&amp;adr=1">Написать администратору</a><br/>
<a href="http://gde.webmoney.ru">Где пополнить в моем городе?</a><br/>
</div>';

require_once ("incfiles/end.php");
exit;
}

// Украина
if ($act == "ua")
{
echo '<div class="gmenu"><b>С помощью терминала (Украина)</b></div>';
echo '<div class="c">
Вы гражданин Украины? Тогда ета информация для Вас.<br/><br/>

При оплате через терминал следуйте экранному меню и будьте, пожалуйста, внимательны при вводе номера кошелька.<br/>
Прием средств терминалами обычно происходит следующим образом:<br/><br/>

- Выберите на сенсорном экране значок "WebMoney".<br/>
- Введите 12 цифр номера U-кошелька: <font color="#FF0000"><b>209695049720</b></font><br/>
- Терминал проверит правильность номера кошелька.<br/>
- Терминал попросит вставить купюры.<br/>
- Получите и сохраните чек.<br/>
- Готово.<br/><br/>

Напишите администратору о том когда и на какую сумму был перевод.<br/>
Обычно от часа до суток идет перевод и буцеры будут начислены.<br/>
</div>';
echo '<div class="c">
<a href="str/pradd.php?act=write&amp;adr=1">Написать администратору</a><br/>
<a href="http://gde.webmoney.ru">Где пополнить в моем городе?</a><br/>
</div>';

require_once ("incfiles/end.php");
exit;
}

// Программы
if ($act == "all")
{
echo '<div class="gmenu"><b>С помощью WebMoney програм</b></div>';
echo '<div class="c">
Вы пользователь WebMoney програм? Тогда ета информация для Вас.<br/><br/>

<b>Реквизиты для перевода:</b><br/><br/>

R<font color="#FF0000"><b>180456171439</b></font> - рубли<br/>
U<font color="#FF0000"><b>209695049720</b></font> - гривны<br/>
Z<font color="#FF0000"><b>978643225360</b></font> - евро<br/>
E<font color="#FF0000"><b>121340305254</b></font> - доллар<br/><br/>

Напишите администратору о том когда и на какую сумму был перевод.<br/>
</div>';
echo '<div class="c">
<a href="str/pradd.php?act=write&amp;adr=1">Написать администратору</a><br/>
<a href="http://gde.webmoney.ru">Где пополнить в моем городе?</a><br/>
</div>';

require_once ("incfiles/end.php");
exit;
}



echo '<div class="c"><center><img src="/img/kep.jpg" alt=""/></center></div>';

echo '<div class="gmenu"><b>Купить буцеры</b></div>';
echo '<div class="menu">
• <a href="pay.php?act=ru">С помощью терминала (Россия)</a><br/>
• <a href="pay.php?act=ua">С помощью терминала (Украина)</a><br/>
• <a href="pay.php?act=all">С помощью WebMoney програм</a><br/>
</div>';

require_once ("incfiles/end.php");
?>
