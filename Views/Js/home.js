// configura as horas
function horas() {
    var data = new Date();
    var hora = data.getHours();
    var min = data.getMinutes();
    var seg = data.getSeconds();

    if (hora < 10) {
        hora = "0" + hora;
    }
    if (min < 10) {
        min = "0" + min;
    }
    if (seg < 10) {
        seg = "0" + seg;
    }

    var divHora = document.getElementById("hora");
    divHora.innerHTML = hora + ': ';

    var divMin = document.getElementById("minuto");
    divMin.innerHTML = min + ': ';;

    var divSeg = document.getElementById("segundo");
    divSeg.innerHTML = seg

    let saudacao = document.getElementById('saudacao');
    if (hora >= 6 && hora < 12) {
        saudacao.innerHTML = 'Bom dia!';
    }
    if (hora >= 12 && hora < 19) {
        saudacao.innerHTML = 'Boa Tarde!';
    }
    if (hora >= 19) {
        saudacao.innerHTML = 'Boa Noite!';
    }
    if (hora >= 00 && hora < 6) {
        saudacao.innerHTML = 'Boa Madrugada!';
    }


}
var tempo = setInterval(horas, 1000);

// configura a data
var data = new Date();
var dia = String(data.getDate()).padStart(2, '0');
var mes = String(data.getMonth() + 1).padStart(2, '0');
var ano = data.getFullYear();
var dataAtual = dia + '/' + mes + '/' + ano;

var semana = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];
var d = new Date();

var showDate = document.getElementById("data");
showDate.innerHTML = semana[d.getDay()] + ", " + dataAtual;