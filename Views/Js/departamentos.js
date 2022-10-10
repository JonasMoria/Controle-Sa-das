
function gerarPDF() {
  var minhaTabela = document.getElementById('TabelaDepartamentos').innerHTML;
  var win = window.open('', '', 'height=900,width=900');
  var html = '<html>' +
    '<head>' +
    '<title>Controle Saídas | Imprimir Setores</title>' +
    '<style>' +
    'table {width: 100%;font: 10px Arial;}#columAcoes {display: none;}' +
    '#cabecalho{width: 80%;margin-left: 10%;margin-right: 10%;text-align: center;display: block}.ocultarImprimir {display: none;}' +
    'table, th, td {border: solid 1px #DDD; border-collapse: collapse;padding: 2px 3px;text-align: center;}' +
    '</style>' +
    '</head>' +
    '<body>' +
    '<figure id="cabecalho"><img src="../Images/imgLogoImprimir.png" alt="imgLogoImprimir"></figure><hr><br>' +
    minhaTabela +
    '</body>' +
    '</html>';
  win.document.write(html);
  win.document.close();
  win.print();
}