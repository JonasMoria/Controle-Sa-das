<style>
    .menuSide {
        height: 100%;
        width: 10%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: rgb(46, 134, 193);
        color: white;
        overflow-x: hidden;
        transition: 0.5s;
        box-shadow: gray 0px 0px 2px 2px;
    }

    .links {
        margin-top: 50%;
    }

    #btnClose {
        text-align: center;
    }

    #btnOpen {
        position: absolute;
        left: 5px;
    }

    .buttons {
        text-align: center;
        margin-bottom: 50%;
    }

    .buttons:hover {
        font-size: 3vh;
    }

    .buttons button {
        background-color: transparent;
        border: none;
    }

    .buttons span {
        color: white;
    }

    .exit {
        position: absolute;
        bottom: 10px;
        left: 0px;
        text-align: center;
        width: 100%;
    }

    .btnExit {
        font-size: 3vh;
        font-weight: 400;
        color: white;
        letter-spacing: 2px;
    }

    .btnExit:hover {
        font-size: 4vh;
        color: red;
    }

    .page {
        margin-left: 11%;
    }

    .boxLocation {
        text-align: center;
        padding: 0.1%;
        margin-bottom: 2%;
        color: darkorange;
        font-weight: 800;
    }
</style>

<nav class="row">
    <div id="menuSide" class="menuSide col-10">
        <span onclick="closeNav()" class="button" style="font-size: 5vh;" id="btnClose">&times;</span> <br>
        <span onclick="openNav()" class="button" id="btnOpen">&#9776;</span>
        <div id="links">
            <form action="../../Controllers/navController.php" method="POST">
                <div class="buttons">
                    <button type="submit" name="go_home">
                        <img src="../../Content/icones/home.svg" class="icon" alt="home"> <br> <span>Home</span>
                    </button>
                </div>
                <div class="buttons">
                    <button type="submit" name="go_departamentos">
                        <img src="../../Content/icones/dept.svg" class="icon" alt="dept"> <br> <span>Setores</span>
                    </button>
                </div>
                <div class="buttons">
                    <button type="submit" name="go_saidas">
                        <img src="../../Content/icones/saidas.svg" class="icon" alt="saidas"> <br> <span>Saídas</span>
                    </button>
                </div>
                <div class="buttons">
                    <button type="submit" name="go_chamados">
                        <img src="../../Content/icones/chamados.svg" class="icon" alt="chamados"> <br> <span>Chamados</span>
                    </button>
                </div>
                <div class="buttons">
                    <button type="submit" name="go_configs">
                        <img src="../../Content/icones/configuracoes.svg" class="icon" alt="Configurações"> <br> <span>Configs</span>
                    </button>
                </div>
                <div class="exit">
                    <button type="submit" name="exit" class="btn btnExit">SAIR</button>
                </div>
            </form>
        </div>
    </div>
</nav>
<div class="page boxLocation">
    <h4 id="location"></h4>
</div>
<script>
    var btnOpen = document.getElementById('btnOpen');
    var btnClose = document.getElementById('btnClose');
    var links = document.getElementById('links').style;
    var menu = document.getElementById('menuSide');
    var width = window.innerWidth;
    btnClose.style.display = 'none';
    btnOpen.style.display = 'none';
    if (width < 500) {
        menu.style.width = '0%';
        links.display = 'none';
        btnOpen.style.display = 'block';
    }

    function openNav() {
        menu.style.width = '40%';
        btnOpen.style.display = 'none';
        links.display = 'block';
        btnClose.style.display = 'block';
    }

    function closeNav() {
        menu.style.width = '0%';
        btnOpen.style.display = 'block';
        links.display = 'none';
        btnClose.style.display = 'none';
    }
</script>