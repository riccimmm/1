<?php

define('_IN_JOHNCMS', 1);

$headmod = 'mainpage';

// Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
$rootpath = '';

//defined('_IN_JOHNCMS') or die('Error: restricted access');

function func_text($type,$kom,$minuta,$name)
{
global $krr1;
global $krr2;

if ($kom == 1)
{$komm1 = $krr1[name];$komm2 = $krr2[name];}
else
{$komm1 = $krr2[name];$komm2 = $krr1[name];}







if ($type == 'twist_one')
{

$i_twist_one = rand(1,3);
switch ($i_twist_one)
{
case "1":$str = '01|twist_one|Матч начался! С мячом "'.$krr1[name].'" Немного о схемах команд: ' . $krr1[shema] . ' у "'.$krr1[name].'" и ' . $krr2[shema] . ' у "'.$krr2[name].'".';break;
case "2":$str = '01|twist_one|'.$krr1[name].' начал с центра поля! Первый тайм открыт! Встреча сегодня, уверен, будет голевой.';break;
case "3":$str = '01|twist_one|Футболисты команды '.$krr1[name].' разыграли мяч с центра поля.';break;
}

}
elseif ($type == 'twist_two')
{

$i_twist_two = rand(1,3);
switch ($i_twist_two)
{
case "1":$str = '46|twist_two|Второй тайм начался! С мячом "'.$krr2[name].'" Немного о схемах команд: ' . $krr1[shema] . ' у "'.$krr1[name].'" и ' . $krr2[shema] . ' у "'.$krr2[name].'".';break;
case "2":$str = '46|twist_two|'.$krr2[name].' начал с центра поля! Второй тайм открыт!';break;
case "3":$str = '46|twist_two|Футболисты команды '.$krr2[name].' разыграли мяч с центра поля.';break;
}

}
elseif ($type == 'finish_one')
{

$i_finish_one = rand(1,3);
switch ($i_finish_one)
{
case "1":$str = '45.0|finish_one|А вот и свисток. Отдохнём немного, друзья!';break;
case "2":$str = '45.0|finish_one|Перерыв! Под свист трибун судья покидает поле!';break;
case "3":$str = '45.0|finish_one|А вот и долгожданный перерыв в матче.';break;
}

}
elseif ($type == 'finish_two')
{

$i_finish_two = rand(1,3);
switch ($i_finish_two)
{
case "1":$str = '93|finish_two|Матч завершился.';break;
case "2":$str = '93|finish_two|Судья даёт финальный свисток!';break;
case "3":$str = '93|finish_two|Ну вот и всё! Матч завершился.';break;
}

}
elseif ($type == 'goal')
{

$i_goal = rand(1,27);
switch ($i_goal)
{
case "1":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Оборона '.$komm2.' рассыпалась во время атаки соперника, '.$name.' не имел права промахнуться с семи метров!</b>';break;
case "2":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' вышел один на один с голкипером, на замахе уложил на газон вратаря и пробил в дальний угол ворот!</b>';break;
case "3":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! От головы партнёра мяч полетел на дальний угол вратарской, откуда '.$name.' с острейшего угла пробил в дальнюю штангу, отскок в сетку!</b>';break;
case "4":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! Пенальти! '.$name.' без проблем развёл мяч и вратаря команды '.$komm2.' по разным углам рамки!</b>';break;
case "5":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Ошибаются игроки обороны при выносе мяча из своей штрафной площади. Мяч после отскока попадает к '.$name.' , который технично посылает мяч в дальний верхний угол ворот!</b>';break;
case "6":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! После того, как '.$name.' вышел на ударную позицию он пробил по воротам из-за пределов штрафной. Мяч попал в игрока '.$komm2.', полетев в притирку со штангой!</b>';break;
case "7":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Прошла передача с правого фланга на '.$name.' который находился в чужой штрафной, '.$name.' оставалось любой частью тела переправить мяч в сетку, что он с успехом и выполнил!</b>';break;
case "8":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Партнеры сделали передачу с линии штрафной на '.$name.', который со всей мощи пробил по воротам. Мяч попал в перекладину, а потом приземлился за чертой ворот!</b>';break;
case "9":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' получил мяч в чужой штрафной и пробил по воротам. По какой-то странной траектории полетел мяч, но прошёл точно под перекладину!</b>';break;
case "10":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' выстрелил метров с тридцати, на линии штрафной защитник пригнулся во избежание рикошета, но это только смутило вратаря, который не успел перегруппироваться!</b>';break;
case "11":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! После подачи с угла поля мяч неудачно отбил перед собой голкипер. '.$name.' оказался на линии вратарской первым на подборе, протолкнув мяч в сетку.</b>';break;
case "12":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Партнер с угла штрафной спокойно навесил мяч на голову '.$name.', который с одиннадцатиметровой отметки головой отправил снаряд в угол ворот!</b>';break;
case "13":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'!  После розыгрыша углового мяч отскочил на линию штрафной, откуда '.$name.' плотным ударом в касание отправил снаряд в угол ворот!</b>';break;
case "14":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' метров с сорока пробил по воротам со стандарта голкипер не сумел допрыгнуть до штанги, а мяч влетел в сетку в притирочку с этой частью каркаса ворот!</b>';break;
case "15":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! Ого-го, совсем неожиданный гол . Заброс с центра поля, и защита ошибается в использовании искусственного офсайда и '.$name.' выходит один на один, обыгрывает голкипера и посылает мяч в пустые ворота!</b>';break;
case "16":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Партнер черпнул мяч с правого фланга, '.$name.' принял мяч на грудь и вторым касанием слёту пробил под дальнюю штангу!</b>';break;
case "17":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' головой прокинул себе снаряд в штрафную, на лету убрал защитника и не давая мячу опуститься на газон выстрелил в угол ворот! Потрясающий гол!</b>';break;
case "18":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.'! Отличная передача с правого фланга, мяч минул практически всех защитников хозяев, которые понадеялись друг на друга и опустился на голову '.$name.' который мастерски переправил снаряд в угол!</b>';break;
case "19":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! Проспали защитники, '.$name.' на грани офсайда выдвинулся один на один и без вопросом прокинул мяч мимо вышедшего голкипера!</b>';break;
case "20":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' получил мяч в чужой штрафной площади от партнера и с десяти метров вогнал мяч точно в верхний левый угол ворот "'.$komm2.'"!</b>';break;
case "21":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! "'.$komm1.'" в контратаке добился успеха! Отменный пас по вертикали, '.$name.' вторым касанием с правого угла вратарской из-под защитника точно пробил в дальний угол!</b>';break;
case "22":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! '.$name.' получил отличный разрезающий пас из глубины поля, убежал от защитников, пробросил мяч мимо голкипера и забил в пустые ворота с 8-ми метров!</b>';break;
case "23":$str = ''.$minuta.'|goal|<b>ГО-О-О-О-О-ОЛ! Забил '.$name.'. Я никогда не видел до такой степени пустых ворот... </b>';break;
case "24":$str = ''.$minuta.'|goal|<b>Мяч вкатил '.$name.' Вратарь не достал бы этот мяч никаким прыжком - ни тигриным, ни леопардийным.  </b>';break;
case "25":$str = ''.$minuta.'|goal|<b>У '.$name.' удар не получился: в землю, с отскоком, в дальний угол и счет открыт.</b>';break;
case "26":$str = ''.$minuta.'|goal|<b>Вратарь выпустил мяч из рук и его пришлось добить. Забивает '.$name.'.</b>';break;
case "27":$str = ''.$minuta.'|goal|<b>'.$name.', может быть, не очень красивым, но очень важным ударом забил гол. </b>';break;
}

}
elseif ($type == 'play_kip')
{

$i_play_kip = rand(1,7);
switch ($i_play_kip)
{
case "1":$str = ''.$minuta.'|warning|'.$name.'! Браво! Красивейший сейв в исполнении голкипера команды '.$komm1.'.';break;
case "2":$str = ''.$minuta.'|warning|'.$name.'! Браво! Красивейший сейв в исполнении голкипера команды '.$komm1.'.';break;
case "3":$str = ''.$minuta.'|warning|'.$name.'! Браво! Красивейший сейв в исполнении голкипера команды '.$komm1.'.';break;
case "4":$str = ''.$minuta.'|warning|Форвард едва не перекинул вратаря! '.$name.' в прыжке успевает задеть мяч рукой!';break;
case "5":$str = ''.$minuta.'|warning|Когда с мячом '.$name.', стоит только разводить руками. Хорошо, если это сделает вратарь, да еще удачно, как в этом эпизоде ';break;
case "6":$str = ''.$minuta.'|warning|Браво! '.$name.' стоит в воpотах как циpкyль!';break;
case "7":$str = ''.$minuta.'|warning|'.$name.' едва не yдаpился головой о штангy, потомy что в детстве, навеpное , мало падал ';break;
}

}
elseif ($type == 'play_bek')
{

$i_play_bek = rand(1,28);
switch ($i_play_bek)
{
case "1":$str = ''.$minuta.'|ugol|Угловой заработали гости, навесная передача в центр штрафной и защитники головой выбили мяч подальше от штрафной.';break;
case "2":$str = ''.$minuta.'|ugol|Угловой заработал '.$name.', однако до удара розыгрыш этого стандарта не дошёл. Всё по-прежнему спокойно.';break;
case "3":$str = ''.$minuta.'|ugol|Навес и мяч судорожно заметался между игроками, первый удар попал в футболиста "'.$komm2.'", а повторный улетел за пределы поля.';break;


case "4":$str = ''.$minuta.'|crest|'.$name.' столкнулся головой со своим партнёром в центре поля, жуткая картина.';break;
case "5":$str = ''.$minuta.'|crest|Пауза в игре. '.$name.' получает помощь - ему свело ногу. Не готов игрок играть ещё весь матч.';break;
case "6":$str = ''.$minuta.'|crest|Практически каждую минуту фиксируются фолы, которые ещё более тормозят, и без того, медленный темп игры. '.$name.' сейчас пришлось даже прибегать к помощи врачей..';break;

case "7":$str = ''.$minuta.'|fol|'.$name.' нарушил правила в метрах сорока от своих ворот.';break;
case "8":$str = ''.$minuta.'|fol|'.$name.' от души врезал своему сопернику по ногам, а арбитр решил лишь на словах "пожурить" за грубость.';break;
case "9":$str = ''.$minuta.'|fol|'.$name.' на фланге пытался обвести двоих соперников, после чего получил по ногам, штрафной назначил арбитр.';break;
case "10":$str = ''.$minuta.'|fol|'.$name.' фолит у своей штрафной, опасный стандарт для "'.$komm2.'".';break;
case "11":$str = ''.$minuta.'|warning|'.$komm2.'ец бьет копытом по газону. Не видно, что же там произошло. Ну в ухо получил он. Так не в глаз же, в конце концов.  ';break;
case "12":$str = ''.$minuta.'|fol|'.$name.' задержал противника за нежную часть тела. ';break;
case "13":$str = ''.$minuta.'|warning|Успел на фланге к мячу '.$name.'. Если бы он успевал иногда подумать - цены бы ему не было. ';break;
case "14":$str = ''.$minuta.'|fol|'.$name.' врезался в игрока, как броненосец в "Запорожец".';break;
case "15":$str = ''.$minuta.'|fol| В борьбе за верховой мяч столкнулись головами '.$name.' и  нападающий команды соперников. Оба упали. Нападающего выносят с поля на носилках. '.$name.' встал, почесал голову... ';break;
case "16":$str = ''.$minuta.'|warning|На ваших экранах '.$name.'. Глядя на него, мы вспоминаем, что официальным спонсором чемпионата является компания "Филипс", которая производит бритвы. ';break;
case "17":$str = ''.$minuta.'|warning|Команда '.$komm2.' за 33-летнюю историю подготовила много футболистов, большинство из них до сих пор выступают за юношеские команды. ';break;
case "18":$str = ''.$minuta.'|warning|Некоторых футболистов, таких миленьких с голубыми глазами, как например '.$name.', принято называть убийцами с глазами ребенка. ';break; 
case "19":$str = ''.$minuta.'|fol|Емy холодно, а нам жаpко '.$name.' в атаке, падает - штpафной !';break;  
case "20":$str = ''.$minuta.'|warning|А это '.$name.'. '.$name.' pазмышляющий. Вы со мной согласны?';break;  
case "21":$str = ''.$minuta.'|warning|Все просто, как y Ленина - '.$name.' настyпил на мяч, но полотеpский номеp не пpошел!';break; 
case "22":$str = ''.$minuta.'|warning|'.$name.' бил левой, но мимо '.$komm1.' слаб, даже с учетом фамилий, котоpые носятся тyт по полю в синей форме.';break; 
case "23":$str = ''.$minuta.'|fol|А ведь, честно говоpя, '.$name.' цеплял игpока немножко yмышлено. И сам '.$name.' схватился за головy, посыпая её пеплом.';break; 
case "24":$str = ''.$minuta.'|warning|'.$komm1.' забpосали овощами, в основном томатами. Фyтбол можете не смотpеть - можете мне на слово веpить!';break; 
case "25":$str = ''.$minuta.'|warning|В команде '.$komm1.' игрок '.$name.' , как pаспpеделитель зажигания в автомобиле.';break; 
case "26":$str = ''.$minuta.'|warning|Игрок '.$name.' все вpемя бpодит в штpафнyю сопеpника, когда исполняются yгловые, штpафные.';break;
case "27":$str = ''.$minuta.'|warning|С забинтованой головой появляется '.$name.'. непонятно, то ли деpнyли за ухо так, что чyть-чyть надоpвали. ';break;
case "28":$str = ''.$minuta.'|warning|Если бы у '.$name.' не было характера он бы продавал газеты. Посмотрите на его физические данные.';break;

}

}
elseif ($type == 'play_hav')
{

$i_play_hav = rand(1,38);
switch ($i_play_hav)
{
case "1":$str = ''.$minuta.'|ugol|Корнер заработал '.$name.', сильная навесная передача и никто до мяча не дотянулся.';break;
case "2":$str = ''.$minuta.'|ugol|Угловой заработал '.$name.', однако до удара розыгрыш этого стандарта не дошёл. Всё по-прежнему спокойно.';break;
case "3":$str = ''.$minuta.'|ugol|Навес и мяч судорожно заметался между игроками, первый удар попал в футболиста "'.$komm2.'", а повторный улетел за пределы поля.';break;



case "4":$str = ''.$minuta.'|crest|'.$name.' вступив в отбор, сам получил повреждение. Небольшая пауза возникает в игре. Игроку нужно перетерпеть боль.';break;
case "5":$str = ''.$minuta.'|crest|Лежит на поле '.$name.'. Вся команда стоит над ним, медики тоже прибежали.';break;
case "6":$str = ''.$minuta.'|crest|"Колдуют" медики над '.$name.' сейчас. Лежит он на поле и держится за спину. Будем надеяться, что продолжит матч.';break;

case "7":$str = ''.$minuta.'|fol|Штрафной удар заработал '.$name.' в 27-ми метрах от чужих ворот, но разыграли его просто отвратительно.';break;
case "8":$str = ''.$minuta.'|fol|'.$name.' от души врезал своему сопернику по ногам, а арбитр решил лишь на словах "пожурить" за грубость.';break;
case "9":$str = ''.$minuta.'|fol|'.$name.' на фланге пытался обвести двоих соперников, после чего получил по ногам, штрафной назначил арбитр.';break;
case "10":$str = ''.$minuta.'|warning|'.$name.' мог забить мяч, но немножко не попал по мячу. ';break;
case "11":$str = ''.$minuta.'|warning|Мяч для '.$name.' был неудобный: ни в грудь, ни в колено, а где-то посередине. Поэтому мяч попал ему в подбородок. Поймать скачущий мяч на таком кочковатом поле, можно только имея вилку, чтобы успеть наколоть его. ';break;
case "12":$str = ''.$minuta.'|warning|'.$name.' попал в верхний угол перекладины!';break;
case "13":$str = ''.$minuta.'|warning|Даже если сделать пять повторов этого удара, мяч не попадет в ворота.';break;
case "14":$str = ''.$minuta.'|fol|'.$name.' встретился с защитником. Стукнулся в него лбом. Отдал мяч и только затем упал.';break;
case "15":$str = ''.$minuta.'|warning|К сожалению, с этой камеры не видно, что '.$name.' был в оффсайде... как, впрочем и со всех других - оффсайда не было. ';break;
case "16":$str = ''.$minuta.'|warning|'.$name.' все сделал, только ударить забыл... Ну и немудрено - столько бежать, имя свое забыть можно....';break;
case "17":$str = ''.$minuta.'|warning|Дождь должен помочь "'.$komm2.'". Почему? Не знаю, но должен...';break;
case "18":$str = ''.$minuta.'|warning|Сбивают '.$name.'... Судья показывает, что помощь врачей уже не нужна.';break;
case "19":$str = ''.$minuta.'|warning|С мячом игрок команды '.$komm2.', перед ним защитник.';break; 
case "20":$str = ''.$minuta.'|warning|Даже если '.$name.' yдлинить в тpи pаза, то до мяча он все pавно не дотянyлся бы.';break;
case "21":$str = ''.$minuta.'|fol|'.$name.' - на тpаве. Что-то там повpедил или емy повpедили. Но паpень он здоpовый, отлежится, зальют водичкой что надо и побежит!';break;
case "22":$str = ''.$minuta.'|warning|Втоpой засыл мяча в штpафнyю оказался yдачнее. Hаносил yдаp симпатичный '.$name.'.';break;
case "23":$str = ''.$minuta.'|warning|'.$name.' ногой боднyл мяч Вот началась штypмовщина.';break;
case "24":$str = ''.$minuta.'|warning|Остается надеятся либо на '.$name.', либо на бога, либо на обоих в лице '.$name.' ';break;
case "25":$str = ''.$minuta.'|fol|Товаpищ '.$name.', такой пас нам не нyжен! '.$name.' ypонил человека на землю...';break;
case "26":$str = ''.$minuta.'|warning|Была надежда, что '.$name.' сыгpает по пpинципy стоялой лошади.';break;
case "27":$str = ''.$minuta.'|warning|'.$name.' упал, набрав скорость и не успевая за ногами.';break;
case "28":$str = ''.$minuta.'|warning|'.$name.' вдpyг ка-ак двинyл, - и пpямо в свою штpафнyю площадкy Откpойте глаза! Все в поpядке! Гола нет! ';break;
case "29":$str = ''.$minuta.'|warning|Тpенеp команды "'.$komm1.'" очень активно ведёт себя y бpовки поля: кpичит, жестикyлиpyет, пьёт, а иногда и кypит...';break;
case "30":$str = ''.$minuta.'|warning|'.$name.' сегодня игpает в белых бyтсах, а в остальном игpает спокойно, ypавновешенно.';break; 
case "31":$str = ''.$minuta.'|fol|'.$name.' только занес ногy для yдаpа, как его по ней и yдаpили.';break; 
case "32":$str = ''.$minuta.'|warning|'.$name.' великолепной свечой поднимает мяч над стадионом! Великолепной, с точки зpения эстетики, но совеpшенно непонятной с точки зpения здpавого смысла!';break; 
case "33":$str = ''.$minuta.'|fol|Hастоящий боец этот '.$name.', всегда yдачно боpется до конца, тyт его как pаз сбили с ног.';break;
case "34":$str = ''.$minuta.'|warning|'.$name.' yдаpил ногой, как клюшкой, как пpодолжением pyки. У него отличные ноги. Он может двигать ими и напpаво, и налево.';break;
case "35":$str = ''.$minuta.'|warning|Картинное было падение у '.$name.' - хотя очень больно. Ну, тут не так больно, как хочется, чтобы соперник получил желтую карточку.';break;
case "36":$str = ''.$minuta.'|warning|'.$name.' действовать нужно быстрее, не бежать быстрее, а действовать быстрее и бежать быстрее...';break;
case "37":$str = ''.$minuta.'|warning|'.$name.' дкакой-то корявый...не то, что играет коряво...не чтобы обидеть... Он узловатый...как штангист легкого веса.';break;
case "37":$str = ''.$minuta.'|warning|'.$name.' преследовал игрока по всему полю и даже наверно последовал за ним в раздевалку, на столько ЭТО было заметно. ';break;
}

}
elseif ($type == 'play_for')
{

$i_play_for = rand(1,41);
switch ($i_play_for)
{
case "1":$str = ''.$minuta.'|ugol|Угловой заработали гости, навесная передача в центр штрафной и защитники головой выбили мяч подальше от штрафной.';break;
case "2":$str = ''.$minuta.'|ugol|Угловой заработал '.$name.', однако до удара розыгрыш этого стандарта не дошёл. Всё по-прежнему спокойно.';break;
case "3":$str = ''.$minuta.'|ugol|Навес и мяч судорожно заметался между игроками, первый удар попал в футболиста "'.$komm2.'", а повторный улетел за пределы поля.';break;

case "4":$str = ''.$minuta.'|warning|Опасно получилось! '.$name.' нанёс удар по воротам, попал в стенку, но мяч отскочил к партнеру, который с острого угла пытался поразить цель! Мимо!.';break;
case "5":$str = ''.$minuta.'|warning|И вновь неплохая атака на ворота команды "'.$komm2.'"! '.$name.' после прострела с правого фланга оказался один на мяче, пробил сходу, но точности не хватило..';break;
case "6":$str = ''.$minuta.'|warning|'.$name.' во второй раз в матче пробивал головой с левого края штрафной, мяч по дуге полетел над голкипером и упал на сетку у дальней девятки!.';break;
case "7":$str = ''.$minuta.'|warning|Ответ в исполнении "'.$komm1.'". '.$name.' наносил удар со штрафного, пытался закрутить мяч в дальний угол, но голкипер на месте.';break;
case "8":$str = ''.$minuta.'|warning|Ещё один опасный выстрел! '.$name.' здорово приложился по мячу метров с двадцати, полети снаряд чуть ниже - быть голу!';break;
case "9":$str = ''.$minuta.'|warning|Фантастика! '.$name.' принял мяч в чужой штрафной, убрал защитника, и вместо того чтобы пробивать по воротам, он принялся тащить мяч вдоль вратарской линии, а откидка назад оказалась неточной.';break;
case "10":$str = ''.$minuta.'|warning|Угловой с правого фланга подали берлинцы, мяч опускался точно на '.$name.', но тот, после могучего замаха левой ногой, промахнулся по мячу!';break;
case "11":$str = ''.$minuta.'|warning|И снова '.$name.'! Сейчас уже с правого края врывался в штрафную и с острого угла пробивал сам, голкипер с большим трудом успел сгруппироваться и отразил мяч перчатками.';break;
case "12":$str = ''.$minuta.'|warning|Ай-яй-яй! Кокой моментище! Партнер протащил мяч в штрафную слева и выкатывал мяч под удар '.$name.', который пробивал мимо вратаря, но защитник в падении отбил мяч ногой с ленточки!';break;
case "12":$str = ''.$minuta.'|warning|'.$name.' перекинул голкипера, который неудачно вышел за пределы штрафной, но до ворот мячу не удалось долететь, так как защитник подстраховал.';break;

case "13":$str = ''.$minuta.'|crest|Мяч выбит за пределы поля, для '.$name.' необходима помощь врачей.';break;
case "14":$str = ''.$minuta.'|crest|'.$name.' оказали помощь врачи команды, в игровом эпизоде футболист "'.$komm1.'" получил небольшое повреждение.';break;
case "15":$str = ''.$minuta.'|crest|'.$name.' пошёл в отчаянный подкат у своей штрафной на левом фланге и сумел выбить снаряд из-под ног опонента, но при этом получил повреждение.';break;

case "16":$str = ''.$minuta.'|fol|'.$name.' нарушает правила в борьбе за верховой мяч.';break;
case "17":$str = ''.$minuta.'|fol|'.$name.' на правом фланге заработал штрафной удар.';break;
case "18":$str = ''.$minuta.'|fol|'.$name.' красиво обыграл опонента, тот нарушает правила против игрока команды '.$komm1.'.';break;
case "19":$str = ''.$minuta.'|fol|'.$name.' красиво обыграл опонента, тот нарушает правила против игрока команды '.$komm1.'.';break;
case "20":$str = ''.$minuta.'|warning|"'.$komm1.'" может играть с любым соперником, вопрос в том, чтобы выиграть.';break;
case "21":$str = ''.$minuta.'|warning|'.$name.' правой бить неудобно, а левая - для того, чтобы ходить. ';break;
case "22":$str = ''.$minuta.'|warning|Ещё один опасный выстрел! '.$name.' здорово приложился по мячу. Мяч разминулся всего на какие-то пару метров со штангой.';break;
case "23":$str = ''.$minuta.'|warning|'.$name.' мне напоминает левшу с двумя правыми ногами.';break;
case "24":$str = ''.$minuta.'|warning|'.$name.' получает мяч. Давай поиграемся...';break;
case "25":$str = ''.$minuta.'|warning|'.$name.' попал в штангу. Но это было после свистка. К тому же это был не '.$name.'.';break; 
case "26":$str = ''.$minuta.'|warning|'.$name.' получает мяч в центре поля. Вся его фигура как будто говорит: "Кому бы дать?" ';break;  
case "27":$str = ''.$minuta.'|warning|Несмотря на хорошую погоду, многие болельщики предпочли переждать дождь дома.';break;  
case "28":$str = ''.$minuta.'|fol|Вместе с мячом летели ноги '.$name.' и других футболистов';break;
case "29":$str = ''.$minuta.'|warning|Мяч пеpехватывает не кто-нибyдь, а сам '.$name.'. ';break;
case "30":$str = ''.$minuta.'|warning|'.$name.' демонстpиpyет техникy бега на дистанци 60м.';break;
case "31":$str = ''.$minuta.'|warning|У '.$name.' сильный удар. Я не со стороны об этом сужу: я запомнил этот удар, когда играл со сборниками на пляжах Копакабаны. ';break;
case "32":$str = ''.$minuta.'|warning|С мячом '.$name.'. Безадресная передача ... на мяче, видимо, адрес не написали...';break;
case "33":$str = ''.$minuta.'|warning|По всем правилам здесь '.$name.' отодрал нападающего гостей.';break;
case "34":$str = ''.$minuta.'|warning|Игроки команды '.$komm2.' приближаются к штрафной площадке... но вштрафную их могут и не пустить.';break;
case "35":$str = ''.$minuta.'|warning|Этот свитер у '.$name.' - счастливый! Он его уже пятнадцать сезонов носит, не снимая!..';break;
case "36":$str = ''.$minuta.'|warning|Вот '.$name.' бежит за мячом, подбегает к вратарю и овладевает им. Вратарь отбил мяч и упал. А добить его некому.';break;
case "37":$str = ''.$minuta.'|warning|'.$name.' имел трёх защитников - двоих сзади и одного перед собой.';break;
case "38":$str = ''.$minuta.'|warning|Длинноногий '.$name.' достал мяч, находящийся в трех метрах от него. Продолжаеться атака команды '.$komm2.'.';break;
case "39":$str = ''.$minuta.'|warning|Какая жаль... Удаp был очень сильным. Мяч попал в головy '.$name.'. Если есть мозги, возможно, будет сотрясение.';break;
case "40":$str = ''.$minuta.'|fol|'.$name.' сегодня вездесyщ - только что атаковал чyжие воpота, а сейчас yже валяется на тpавке около своих.';break;
case "41":$str = ''.$minuta.'|ugol|Пенсионным бегом '.$name.' побежал подавать yгловой. Игроки команды '.$komm1.' идyт впеpёд. Свой зад они пpосто забpосили. ';break; 
}

}elseif ($type == 'yellow')
{
$i_yellow = rand(1,7);
switch ($i_yellow)
{
case "1":$str = ''.$minuta.'|yellow|'.$name.' получает предупреждение, рукой сыграл игрок команды '.$komm2.', а потом ещё начал спорить с арбитром матча.';break;
case "2":$str = ''.$minuta.'|yellow|'.$name.' откровенно опасно играл в подкате против опонента. По ноге не досталось, но за намерение грубо сфолить получил карточку игрок команды "'.$komm2.'".';break;
case "3":$str = ''.$minuta.'|yellow|Жёлтую карточку получил '.$name.'. Потерял мяч, в итоге пришлось нарушить правила, сорвав атаку соперника.';break;

case "4":$str = ''.$minuta.'|yellow|'.$name.' сорвал опасную атаку за что и получил жёлтую карточку.';break;
case "5":$str = ''.$minuta.'|yellow|'.$name.' откровенно опасно играл в подкате против опонента. По ноге не досталось, но за намерение грубо сфолить получил карточку игрок команды "'.$komm2.'".';break;
case "6":$str = ''.$minuta.'|yellow|Жёлтую карточку получил '.$name.'. Потерял мяч, в итоге пришлось нарушить правила, сорвав атаку соперника.';break;
case "7":$str = ''.$minuta.'|yellow|Судья достает из широких штанин... Э-э-э, я имею ввиду желтую карточку. Карточку получил '.$name.'. ';break;

}
}







return $str;
}
?>