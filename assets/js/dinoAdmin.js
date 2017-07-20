function mudarTamanhoFontePainel() {
    var rng = document.querySelector("input#tamanhoDaFonte");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoDaFontePx").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//tamanho fonte resumo lista
function mudarTamanhoFontePainelResumoLista() {
    /*var x = document.getElementById("tamanhoDaFonteResumo").value;
    document.getElementById("mostrarTamanhoDaFontePxResumoLista").innerHTML = "Tamanho da fonte:" + x+"px";*/

    var rng = document.querySelector("input#tamanhoDaFonteResumo");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoDaFontePxResumoLista").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//tamanho da fonte Data
function mudarTamanhoFontePainelDataLista() {
    /*var x = document.getElementById("tamanhoDataLista").value;
    document.getElementById("mostrarTamanhoDaFontePxData").innerHTML = "Tamanho da fonte:" + x+"px";*/

    var rng = document.querySelector("input#tamanhoDataLista");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoDaFontePxData").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

function mudarCorDoTituloLista() {
	var x = document.getElementById("corInput").value;
	document.getElementById("mostarCorTituloLista").innerHTML = "Cor: " + x;
}

function mudarCorDaDataLista() {
	var x = document.getElementById("corInputData").value;
	document.getElementById("mostarCorDataLista").innerHTML = "Cor: " + x;
}

//tamanho da imagem da lista
function mudarTamanhoImagemLista() {
    /*var x = document.getElementById("tamanhoImagemLista").value;
    document.getElementById("mostrarTamanhoDaImagemPx").innerHTML = "Tamanho da Imagem: width: " + x+"px";*/

    var rng = document.querySelector("input#tamanhoImagemLista");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoDaImagemPx").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'><div class='prevImageControl' style='width:"+rng.value+"px;height:"+rng.value+"px;background:#ccc;'></div></p> ";
        });
      });
    }
}

//tamanho do titulo Interno
function mudarTamanhoTituloInterno() {
    /*var x = document.getElementById("tamanhoFonteTituloInterno").value;
    document.getElementById("mostrarTamanhoFonteTituloInterno").innerHTML = "Tamanho do titulo: " + x+"px";*/

    var rng = document.querySelector("input#tamanhoFonteTituloInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoFonteTituloInterno").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//tamanho do Resumo Interno
function mudarTamanhoResumoInterno() {
    /*var x = document.getElementById("tamanhoFonteResumoInterno").value;
    document.getElementById("mostrarTamanhoFonteResumoInterno").innerHTML = "Tamanho do resumo: " + x+"px";*/

    var rng = document.querySelector("input#tamanhoFonteResumoInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoFonteResumoInterno").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//mudar cor do titulo interno
function mudarCorDoTituloInterno() {
    var x = document.getElementById("corInputTituloInterno").value;
    document.getElementById("mostarCorTituloInterno").innerHTML = "Cor: " + x;
}

//mudar cor do resumo interno
function mudarCorDoResumoInterno() {
    var x = document.getElementById("corInputResumoInterno").value;
    document.getElementById("mostarCorResumoInterno").innerHTML = "Cor: " + x;
}

//mudar tamanho do local Interno
function mudarTamanhoFonteLocalInterno() {
    /*var x = document.getElementById("tamanhoFonteLocalInterno").value;
    document.getElementById("mostrarTamanhoFonteLocalInterno").innerHTML = "Tamanho: " + x +"px";*/

    var rng = document.querySelector("input#tamanhoFonteLocalInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoFonteLocalInterno").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//mudar cor do Local interno
function mudarCorDoLocalInterno() {
    var x = document.getElementById("corInputLocalInterno").value;
    document.getElementById("mostarCorLocalInterno").innerHTML = "Cor: " + x;
}

//mudar tamanho da Data Interno
function mudarTamanhoFonteDataInterno() {
    /*var x = document.getElementById("tamanhoFonteDataInterno").value;
    document.getElementById("mostrarTamanhoFonteDataInterno").innerHTML = "Tamanho: " + x +"px";*/

    var rng = document.querySelector("input#tamanhoFonteDataInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoFonteDataInterno").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//mudar cor da Data interno
function mudarCorDaDataInterno() {
    var x = document.getElementById("corInputDataInterno").value;
    document.getElementById("mostarCorDataInterno").innerHTML = "Cor: " + x;
}

//mudar tamanho da Data Interno
function mudarTamanhoFonteCorpoInterno() {
    /*var x = document.getElementById("tamanhoFonteCorpoInterno").value;
    document.getElementById("mostrarTamanhoFonteCorpoInterno").innerHTML = "Tamanho: " + x +"px";*/

    var rng = document.querySelector("input#tamanhoFonteCorpoInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarTamanhoFonteCorpoInterno").innerHTML = "font-size:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'>Fonte</p> ";
        });
      });
    }
}

//mudar cor do Corpo interno
function mudarCorDoCorpoInterno() {
    var x = document.getElementById("corInputCorpoInterno").value;
    document.getElementById("mostarCorCorpoInterno").innerHTML = "Cor: " + x;
}

//mudar Width Imagem Interno
function mudarWidthImagemInterno() {
    /*var x = document.getElementById("tamanhoWidthInputInterno").value;
    document.getElementById("mostrarWidthImagemInterno").innerHTML = "Width: " + x +"%";*/

    var rng = document.querySelector("input#tamanhoWidthInputInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarWidthImagemInterno").innerHTML = "Width:"+rng.value+"%" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'><div class='prevImageControl' style='width:"+rng.value+"%;height:"+rng.value+"px;background:#ccc;'></div></p> ";
        });
      });
    }
}

//mudar para float a imagem do post
function mudarCheckedFloatLeftInterno() {
    var x = document.getElementById("checkedFloatLeft").value;
    document.getElementById("mostrarCheckedFloatLeft").innerHTML = "Float: " + x +"";
}

//mudar tamanho vídeo Interno
function mudarWidthVideoInterno() {
    /*var x = document.getElementById("tamanhoVideoInputInterno").value;
    document.getElementById("mostrarVideoInterno").innerHTML = "Width: " + x +"%";*/

    var rng = document.querySelector("input#tamanhoVideoInputInterno");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarVideoInterno").innerHTML = "Width:"+rng.value+"%" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'><div class='prevImageControl' style='width:"+rng.value+"%;height:"+rng.value+"px;background:#ccc;'></div></p> ";
        });
      });
    }

}

//mudar tamanho vídeo Interno height
function mudarWidthVideoInternoHeight() {
    /*var x = document.getElementById("tamanhoVideoInputInternoHeight").value;
    document.getElementById("mostrarVideoInternoHeight").innerHTML = "Height: " + x +"px";*/

    var rng = document.querySelector("input#tamanhoVideoInputInternoHeight");

    read("mousedown");
    read("mousemove");

    function read(evtType) {
      rng.addEventListener(evtType, function() {
        window.requestAnimationFrame(function () {
          document.querySelector("p#mostrarVideoInternoHeight").innerHTML = "Height:"+rng.value+"px" + "<p id='tamanhoDaFonte' style='font-size:"+rng.value+"px;'><div class='prevImageControl' style='width:"+rng.value+"px;height:"+rng.value+"px;background:#ccc;'></div></p> ";
        });
      });
    }
}

$(document).ready(function () {
    $("div#dinoCaixa .restaurar").on("click", function (event) {
        var p = $(this).closest("div").children("input.padrao").val();
        var t = $(this).closest("div").children("textarea, input[type=range]");
        $(t).val(p);
    });

    $(".mudarTamanhoDaFonteBt").hide();
    //mudarTamanhoFontePainel();
    $(".mudarTamanhoDaFonteBt").on("click", function(e) {
    	mudarTamanhoFontePainel();
    	e.preventDefault();
    });

    $(".mudarTamanhoDaFonteBtResumo").hide();
    //mudarTamanhoFontePainelResumoLista();
    $(".mudarTamanhoDaFonteBtResumo").on("click", function(e) {
    	mudarTamanhoFontePainelResumoLista();
    	e.preventDefault();
    });

    //tamanho da fonte data
    $(".mudarTamanhoDaFonteBtData").hide();
    $(".mudarTamanhoDaFonteBtData").on("click", function(e) {
    	mudarTamanhoFontePainelDataLista();
    	e.preventDefault();
    });

    //função de autoclick no contador do tamanho de fonte
    $("input#tamanhoDaFonte").on("click", function(){
		$("button.mudarTamanhoDaFonteBt").click();
	});

     //função de autoclick no contador do tamanho de fonte do Resumo
	$("input#tamanhoDaFonteResumo").on("click", function(){
		$("button.mudarTamanhoDaFonteBtResumo").click();
	});

	//função de autoclick no contador do tamanho de fonte de Data
	$("input#tamanhoDataLista").on("click", function(){
		$("button.mudarTamanhoDaFonteBtData").click();
	});

	//definindo cor do titulo da lista
	$("input#submit").on("click", function(){
		mudarCorDoTituloLista();
	});



    //tamanho da imagem noticias Lista
    $(".mudarTamanhoDaImagem").hide();
    $(".mudarTamanhoDaImagem").on("click", function(e) {
        mudarTamanhoImagemLista();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho da imagem da lista
    $("input#tamanhoImagemLista").on("click", function(){
        $("button.mudarTamanhoDaImagem").click();
    });



    //tamanho do titulo Interno
    $(".btMudarTamanhoDoTituloInterno").hide();
    $(".btMudarTamanhoDoTituloInterno").on("click", function(e) {
        mudarTamanhoTituloInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho de fonte do titulo Interno
    $("input#tamanhoFonteTituloInterno").on("click", function(){
        $("button.btMudarTamanhoDoTituloInterno").click();
    });


    //tamanho do Resumo Interno
    $(".btMudarTamanhoDoResumoInterno").hide();
    $(".btMudarTamanhoDoResumoInterno").on("click", function(e) {
        mudarTamanhoResumoInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho do Resumo Interno
    $("input#tamanhoFonteResumoInterno").on("click", function(){
        $("button.btMudarTamanhoDoResumoInterno").click();
    });


    //definindo cor do titulo Interno
    $("input#submit").on("click", function(){
        mudarCorDoTituloInterno();
    });

    //cor do resumo interno
    $("input#submit").on("click", function(){
        mudarCorDoResumoInterno();
    });


    //tamanho do Local Interno
    $(".btMudarTamanhoDoLocalInterno").hide();
    $(".btMudarTamanhoDoLocalInterno").on("click", function(e) {
        mudarTamanhoFonteLocalInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho do Local Interno
    $("input#tamanhoFonteLocalInterno").on("click", function(){
        $("button.btMudarTamanhoDoLocalInterno").click();
    });

    //cor do Local interno
    $("input#submit").on("click", function(){
        mudarCorDoLocalInterno();
    });



    //tamanho da Data Interno
    $(".btMudarTamanhoDaDataInterno").hide();
    $(".btMudarTamanhoDaDataInterno").on("click", function(e) {
        mudarTamanhoFonteDataInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho da Data Interno
    $("input#tamanhoFonteDataInterno").on("click", function(){
        $("button.btMudarTamanhoDaDataInterno").click();
    });

    //cor da Data interno
    $("input#submit").on("click", function(){
        mudarCorDaDataInterno();
    });


    //tamanho do Corpo Interno
    $(".btMudarTamanhoDoCorpoInterno").hide();
    $(".btMudarTamanhoDoCorpoInterno").on("click", function(e) {
        mudarTamanhoFonteCorpoInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho do corpo Interno
    $("input#tamanhoFonteCorpoInterno").on("click", function(){
        $("button.btMudarTamanhoDoCorpoInterno").click();
    });

    //cor do Corpo interno
    $("input#submit").on("click", function(){
        mudarCorDoCorpoInterno();
    });

    //Width Imagem Interno
    $(".btMudarWidthImagemInterno").hide();
    $(".btMudarWidthImagemInterno").on("click", function(e) {
        mudarWidthImagemInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho do corpo Interno
    $("input#tamanhoWidthInputInterno").on("click", function(){
        $("button.btMudarWidthImagemInterno").click();
    });



    //Width Imagem Interno
    $(".btMudarFloatLeftInterno").hide();
    $(".btMudarFloatLeftInterno").on("click", function(e) {
        mudarCheckedFloatLeftInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho do corpo Interno
    $("input#checkedFloatLeft").on("click", function(){
        $("button.btMudarFloatLeftInterno").click();
    });


    //tamanho Width video Interno
    $(".btMudarTamanhoVideoInterno").hide();
    $(".btMudarTamanhoVideoInterno").on("click", function(e) {
        mudarWidthVideoInterno();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho width do video interno
    $("input#tamanhoVideoInputInterno").on("click", function(){
        $("button.btMudarTamanhoVideoInterno").click();
    });


    //tamanho Height video Interno
    $(".btMudarTamanhoVideoInternoHeight").hide();
    $(".btMudarTamanhoVideoInternoHeight").on("click", function(e) {
        mudarWidthVideoInternoHeight();
        e.preventDefault();
    });

    //função de autoclick no contador do tamanho Height do video interno
    $("input#tamanhoVideoInputInternoHeight").on("click", function(){
        $("button.btMudarTamanhoVideoInternoHeight").click();
    });



    //Restaurar tamanho da fonte do titulo da Lista
    $("#restartTituloLista").on("click", function() {
        jQuery("input#tamanhoDaFonte").val(20);
    });

    //Restaurar tamanho do resumo da lista
    $("#restartResumoLista").on("click", function() {
        jQuery("input#tamanhoDaFonteResumo").val(15);
    });

    //Restaurar tamanho da Data da lista
    $("#restartDataLista").on("click", function() {
        jQuery("input#tamanhoDataLista").val(15);
    });

    //Restaurar cor do titulo da lista
    $("#restartColorTituloLista").on("click", function() {
        jQuery("input#corInput").val("#000");
    });

    //Restaurar cor da Data da lista
    $("#restartColorDataLista").on("click", function() {
        jQuery("input#corInputData").val("#000");
    });

    //Restaurar tamanho da imagem da lista
    $("#restartTamanhoImagemLista").on("click", function() {
        jQuery("input#tamanhoImagemLista").val(120);
    });

    //Restaurar tamanho do titulo da lista
    $("#restartTituloInternodaLista").on("click", function() {
        jQuery("input#tamanhoFonteTituloInterno").val(40);
        jQuery('.dinotitulo h1').css("display", "none");
    });

    //Restaurar tamanho da fonte do Resumo
    $("#restartInternoResumo").on("click", function() {
        jQuery("input#tamanhoFonteResumoInterno").val(18);
    });

    //Restaurar cor da fonte do Titulo interno
    $("#restartCorTituloLista").on("click", function() {
        jQuery("input#corInputTituloInterno").val("#000");
    });

    //Restaurar cor do resumo Interno
    $("#restartCordoResumoInterno").on("click", function() {
        jQuery("input#corInputResumoInterno").val("#888");
    });

    //Restaurar tamanho da fonte do local interno
    $("#restartTamanhoFonteLocal").on("click", function() {
        jQuery("input#tamanhoFonteLocalInterno").val(15);
    });

    //Restaurar cor do Local interno
    $("#restartCorLocal").on("click", function() {
        jQuery("input#corInputLocalInterno").val("#888");
    });

    //Restaurar tamanho da Data interno
    $("#restartTamanhoFonteData").on("click", function() {
        jQuery("input#tamanhoFonteDataInterno").val(15);
    });

    //Restaurar cor da data interno
    $("#restartCorDataInterno").on("click", function() {
        jQuery("input#corInputDataInterno").val("#888");
    });

    //Restaurar tamanho da fonte do corpo interno
    $("#restartCorpoInterno").on("click", function() {
        jQuery("input#tamanhoFonteCorpoInterno").val(15);
    });

    //Restaurar cor da fonte do corpo interno
    $("#restartImgVideArquivoInterno").on("click", function() {
        jQuery("input#tamanhoWidthInputInterno").val(40);
        jQuery("input#tamanhoVideoInputInterno").val(50);
        jQuery("input#tamanhoVideoInputInternoHeight").val(200);
    });

	  $('[data-toggle="tooltip"]').tooltip();

    
});

