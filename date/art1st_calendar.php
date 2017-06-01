<?
/************************************************************************
*       Title           :       Art1st Calendar                         *
*       Author          :       Art1st                                  *
*       Version         :       2.0                                     *
*       Status          :       Freeware                                *
*       FileName        :       calendar.php                            *
*       Release date    :       June  12, 2003                          *
*       HomePage        :       http://art1st.far.ru (protected page)   *
*       eMail           :       art1st@freemail.ru                      *
*       Description     :       Simple calendar with some function      *
*       Requirements    :       PHP 3 or higher                         *
*       Thanks To       :       State University of Management (Moscow) *
*************************************************************************
*       ¬ызов скрипта   :                                               *
*               ѕросто календарь на текущий мес¤ц - calendar.php        *
*                алендарь на любой мес¤ц -                              *
*                       calendar.php?month=номер мес¤ца-номер года      *
*                       например, "calendar.php?month=6-2003"           *
************************************************************************/
//»ндивидуальные настройки скрипта
        $ac_font_size = "10";           //–азмер шрифта (только число)
        $ac_font_color = "black";       //?вет шрифта (в любом представлении: название, RGB, etc. [html-формат])
        $ac_main_color = "white";       //ќсновной цвет календар¤ (ќбычные дни) (аналогично цвету шрифта)
        $ac_second_color = "silver";    //¬торостепенный цвет календар¤ (аналогично цвету шрифта)
                                        // (“екущий день, заголовок календар¤)
        $ac_navigator = true;           //¬ывод строки навигации по мес¤цам (true/false)
//ћассив названий мес¤цев
        $mon_name = array
        (
        "январь","‘евраль","ћарт","јпрель","ћай","»юнь",
        "»юль","јвгуст","—ент¤брь","ќкт¤брь","Ќо¤брь","?екабрь"
        );
//ћассив продолжительностей мес¤цев
        $nod = array (31,28,31,30,31,30,31,31,30,31,30,31);
//ќпределение мес¤ца и года дл¤ календар¤
if (!isset($month))
        {
        $ac_month = date("n");
        $ac_year = date("Y");
        $ac_j_dom = date("j");
        $ac_j_dow = date("w");
        }
        else
        {
        list ($ac_month,$ac_year) = explode ("-",$month);
        if ($ac_year<1980) $ac_year = 1980;
        if ($ac_year>2030) $ac_year = 2030;
        if ($ac_month != date("n") or $ac_year != date("Y"))
                {
                $ac_j_dom = 1;
                $ac_j_dow = date("w",mktime(0,0,0,$ac_month,1,$ac_year));
                }
                else
                {
                $ac_j_dom = date("j");
                $ac_j_dow = date("w");
                }
        }
// орректировка продолжительности феврал¤ в високосном году
if ($ac_year%4==0) {$nod[1]=29;}
//ќпределение предыдущих/следующих мес¤цев/годов
$temp_month = $ac_month + 1;
if ($temp_month!=13)
        {
        $ac_month_next = "$temp_month-$ac_year";
        }
        else
        {
        $temp_year = $ac_year + 1;
        $ac_month_next = "1-$temp_year";
        }
$temp_month = $ac_month - 1;
if ($temp_month!=0)
        {
        $ac_month_prev = "$temp_month-$ac_year";
        }
        else
        {
        $temp_year = $ac_year - 1;
        $ac_month_prev = "12-$temp_year";
        }
$temp_year = $ac_year + 1;
$ac_year_next = "$ac_month-$temp_year";
$temp_year = $ac_year - 1;
$ac_year_prev = "$ac_month-$temp_year";
//ќпределение названи¤ мес¤ца
$ac_mon=$mon_name[$ac_month-1];
// орректировка номера дн¤ недели из западно-европейской в русскую
if ($ac_j_dow == 0) $ac_j_dow = 7;
//ќпределение дн¤ недели первого дн¤ мес¤ца
$ac_1_dow = $ac_j_dow - ($ac_j_dom%7 - 1);
if ($ac_1_dow < 1) $ac_1_dow+=7;
if ($ac_1_dow > 7) $ac_1_dow-=7;
//ќпределение числа дней мес¤ца
$ac_nod = $nod[$ac_month-1];
//ќпределение количества недель в мес¤це
$ac_now=5;
if ($ac_1_dow-1+$ac_nod<29) {$ac_now=4;}
        else if ($ac_1_dow-1+$ac_nod>35) {$ac_now=6;}
//ѕредотвращение вывода текущего дн¤ дл¤ нетекущего мес¤ца
if ($ac_month != date("n") or $ac_year != date("Y")) $ac_j_dom = -10;
//¬ывод шапки календар¤
echo "
<table border=0 cellspacing=1 cellpadding=1 bgcolor=black style=\"font-size: $ac_font_size pt; color: $ac_font_color; font-family: verdana\">
<tr bgcolor=$ac_second_color>
        <td colspan=7 align=center>
        $ac_mon $ac_year
        </td>
</tr>
<tr bgcolor=$ac_second_color>
        <td>ѕн</td><td>¬т</td><td>—р</td><td>„т</td><td>ѕт</td><td>—б</td><td>¬с</td>
";
//¬ывод содержимого календар¤
for ($i=0;$i<$ac_now*7;$i++)
        {
        if ($i%7==0) {echo "</tr>\n<tr align=center bgcolor=$ac_main_color>\n\t";}
        if ($i-$ac_1_dow+2!=$ac_j_dom) {echo "<td>";} else echo "<td bgcolor=$ac_second_color>";
        if (($i<$ac_1_dow-1)||($i>$ac_nod+$ac_1_dow-2)) {echo "&nbsp;";} else {echo $i-$ac_1_dow+2;}
        echo "</td>\n\t";
        }
//—трока навигации по мес¤цам
if ($ac_navigator)
echo "
</tr>
<tr bgcolor=$ac_second_color>
        <td colspan=7 align=center style=\"font-size: 8pt;\"><b>
        <a href=\"calendar.php?month=$ac_year_prev\" title=\"vод назад\" style=\"color:black;text-decoration: none;\">&lt;&lt;</a>&nbsp;
        <a href=\"calendar.php?month=$ac_month_prev\" title=\"ћес¤ц назад\" style=\"color:black;text-decoration: none;\">&lt;</a>&nbsp;
        <a href=\"calendar.php\" title=\"“екущий мес¤ц\" style=\"color:black;text-decoration: none;\">Х</a>&nbsp;
        <a href=\"calendar.php?month=$ac_month_next\" title=\"ћес¤ц вперед\" style=\"color:black;text-decoration: none;\">&gt;</a>&nbsp;
        <a href=\"calendar.php?month=$ac_year_next\" title=\"vод вперед\" style=\"color:black;text-decoration: none;\">&gt;&gt;</a>
        </b></td>
";
echo "
</tr>
</table>";
?>
