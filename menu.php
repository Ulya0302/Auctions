<!--<nav role = "navigation" >-->
<!--    <ul>-->
<!--        <li>-->
<!--            <a>Аукционы</a>-->
<!--			         	<a class="dropdown-item" href="auctions_stat.php">Статистика по продажам аукционов</a>-->
<!--			        	<a class="dropdown-item" href="#">Статистика по аукционам</a>-->
<!--        			</div>-->
<!--	        </li>-->
<!--	        <li class="nav-item dropdown">-->
<!--	        	<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdow" aria-haspopup="true" aria-expanded="false">Участники</a>-->
<!--	        	<div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
<!--	        		<a href="auctions_stat.php">Статистика по продавцам</a>-->
<!--	        		<div class="dropdown-divider"></div>	-->
<!--	    			<a href="auctions_stat.php">Статистика по покупателям</a>-->
<!--	    		</div>-->
<!--	    	</li>	  -->
<!--		</ul>-->
<!--	</div>-->
<!--</nav>-->
<!---->

<link rel="stylesheet" href="css/dropdown-menu.css" type="text/css">
<nav>
    <div class="dropdown" >
        <button class="dropbtn">Аукционы</button>
        <div class="dropdown-content">
            <a href="add_auction.php">Добавить аукцион</a>
            <a href="auctions_stat.php">Статистика по продажам аукционов</a>
            <a href="auction_chronology.php">Хронология аукционов</a>
            <a href="auc_place_stat.php">Аукционы по месту</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Участники</button>
        <div class="dropdown-content">
            <a href="participant_stat.php">Статистика по участникам</a>
            <a href="add_participant.php">Добавить нового участника</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Лоты</button>
        <div class="dropdown-content">
            <a href="add_lot.php">Добавить новый лот</a>
            <a href="menu.php">Показать текущие места</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Места</button>
        <div class="dropdown-content">
            <a href="add_place.php">Добавить место</a>
            <a href="all_place.php">Показать текущие места</a>
        </div>
    </div>
</nav>
<hr/>


