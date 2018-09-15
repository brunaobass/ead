var url_base = 'http://localhost/ead/painel/modulos/';
$(document).ready(function(){
    
    $('.form-edit-modulo').on('submit',editarModulo);
    $('.add').on('submit',addModulo);
});
function addModulo(e){
  e.preventDefault();
  var dados = $(this).serialize(); 
  console.log(dados.modulo);
  var url_base = 'http://localhost/ead/painel/modulos/';
  $.ajax({
      url:url_base+'adicionar',
      type:'POST',
      data:dados,
      dataType:'json',
      success:function(json){
          listaModulos(json);
      },
      error: function (jqXHR, textStatus, errorThrown) {
           console.log("Erro: "+textStatus); 
      }
  });
    console.log(dados);
  
}
function editarModulo(e){
  
  e.preventDefault();
  var dados = $(this).serialize(); 
  console.log(dados.modulo);
  var url_base = 'http://localhost/ead/painel/modulos/';
  $.ajax({
      url:url_base+'editar',
      type:'POST',
      data:dados,
      dataType:'json',
      success:function(json){
          listaModulos(json);
      },
      error: function (jqXHR, textStatus, errorThrown) {
           console.log("Erro: "+textStatus); 
      }
  });
  console.log(dados);
  
}
function deleteModulo(obj){
    var id_modulo = $(obj).attr('data-modulo-id');
    
    $.ajax({
        url:url_base+'deletar',
        type:'POST',
        data:{id:id_modulo},
        dataType:'json',
        success:function(json){
            listaModulos(json);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Deu ruim: "+errorThrown);
        }
    });
}

function deleteAula(obj){
    var id_aula = $(obj).attr('data-aula-id');
    var url_base = 'http://localhost/ead/painel/aulas/';
    $.ajax({
        url:url_base+'deletar',
        type:'POST',
        data:{id:id_aula},
        dataType:'json',
        success:function(json){
            listaAulas(json);
            console.log('Aula deletada com sucesso...');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Deu ruim: "+errorThrown);
        }
    });
}
function adicionarQuestao(obj){
    
    var id_questao = parseInt($(obj).attr('data-id-ultima-questao')) + 1;
    var html_questao = '<div class="questao">\n\
                    <div class="form-group">\n\
                        <strong>\n\
                            <span>'+id_questao+'- </span>\n\
                            <span class="enunciado">Nova Questão</span>\n\
                        </strong>\n\
                        <a href="javascript:;" onclick="editarQuestao(this)" class="btn-editar-alternativa"\n\
                            data-id-questao ="'+id_questao+'">\n\
                            <i class="far fa-edit editar"></i>\n\
                        </a>\n\
                        \n\
                        <input type="text" name="questao'+id_questao+'" class="input-hidden" \n\
                            value="Nova Questão">\n\
                        <input type="hidden" name="id-questao'+id_questao+'" value="'+id_questao+'">\n\
                    </div><!--questao-->\n\
                    <ul class="lista lista-opcoes" id="opcoes-questao'+id_questao+'">\n\
                    </ul><!--lista-opcoes-->';
    
    var html_alternativas;
    $('#areaquestao').append(html_questao);
    $(obj).attr('data-id-ultima-questao',id_questao);
    
    for(var i = 1; i<=4; i++){
       html_alternativas = 
               '<li class="form-group" id="quest'+id_questao+'alt'+i+'">\n\
                    <input type="radio" name="resposta-questao'+id_questao+'" value="'+i+'"\n\
                        '+((i==1) ? 'checked="checked"' : '')+'>\n\
                    <span>Opção '+i+'</span>\n\
                    \n\
                    <a href="javascript:;" onclick="editarAlternativa(this)" class="btn-editar-alternativa"\n\
                        data-id-questao ="'+id_questao+'" data-id-alternativa="'+i+'">\n\
                        <i class="far fa-edit editar"></i>\n\
                    </a>\n\
                    \n\
                    <input type="text" name="quest'+id_questao+'-alt'+i+'" class="input-hidden" \n\
                        value="Opção '+i+'">\n\
                    <input type="hidden" name="id-quest'+id_questao+'-alt'+i+'" value="'+i+'">\n\
                </li>'; 
        
        $('#opcoes-questao'+id_questao).append(html_alternativas);
    }
    
    $('input[name="id-ultima-questao"]').val(id_questao);
    
    console.log("ULTIMA QUESTAO: "+$('input[name="id-ultima-questao"]').val());
    console.log("ID da nova questão: "+id_questao);
}
function editarQuestionario(obj){

    var id_questao = $(obj).attr('data-id-questionario');
    var questao = $(obj).parent().find('span');
    var input = $(obj).parent().find('[type="text"]');
   
    input.val(questao.html());
    input.show();
    questao.hide();
    $(obj).hide();
    
    input.select();
    
    var noBlur = false;
    input.blur(function(){
        if(!noBlur){
            noBlur = true;
            questao.html(input.val());
            
            questao.show();
            $(obj).show();
            input.hide();
        }
    });
}
function editarQuestao(obj){

    var id_questao = $(obj).attr('data-id-questao');
    var questao = $(obj).parent().find('.enunciado');
    var input = $(obj).parent().find('[type="text"]');
   
    input.val(questao.html());
    input.show();
    questao.hide();
    $(obj).hide();
    
    input.select();
    
    var noBlur = false;
    input.blur(function(){
        if(!noBlur){
            noBlur = true;
            questao.html(input.val());
            
            questao.show();
            $(obj).show();
            input.hide();
        }
    });
}
function editarAlternativa(obj){

    var id_questao = $(obj).attr('data-id-questao');
    var id_alternativa = $(obj).attr('data-id-alternativa');
    var alternativa = $(obj).parent().find('span');
    var input = $(obj).parent().find('[type="text"]');
    var botao = $(this);
    
    
    input.val(alternativa.html());
    input.show();
    alternativa.hide();
    $(obj).hide();
    
    input.select();
    
    var noBlur = false;
    input.blur(function(){
        if(!noBlur){
            noBlur = true;
            console.log(alternativa.html());
            alternativa.html(input.val());
            
            alternativa.show();
            $(obj).show();
            input.hide();
        }
    });
}
function marcarAssistido(obj){
    var id = $(obj).attr('data-id');
    console.log(id);
    
    $.ajax({
        url:'http://localhost/ead/ajax/marcar_assistido',
        type:'POST',
        data:{id:id},
        success:function(){
            console.log('Deu certo');
        }
    });
    $(obj).remove();
}
$(function(){
    $(".demo").starRating({
        totalStars:5,
        emptyColor: 'lightgray',
        // star color on hover
        hoverColor: 'yellow',
        // star color on active
        activeColor: 'gold',
        // star color on rated
        ratedColor: 'gold',
        disableAfterRate: false,
        
        callback:function(currentRating){
            alert("Rating: "+currentRating);
        }

    });
    
    
});

function listaModulos(modulos){
    
    $('#lista-modulos').html('');

    console.log("Tamanho: "+modulos.length);
    for(var i in modulos){

        $('#lista-modulos').append(
                '<li>\n\
                    <span class="nome-modulo">'+modulos[i].nome+'</span>\n\
                    <a href="javascript:;" onclick="editForm(this)" data-modulo-id="'+modulos[i].id+'">\n\
                        <i class="far fa-edit editar"></i>\n\
                    </a>\n\
                    <a href="javascript:;" onclick="deleteModulo(this)" data-modulo-id="'+modulos[i].id+'">\n\
                        <i class="far fa-trash-alt excluir"></i>\n\
                    </a>\n\
                    <form method="POST" class="form-add-modulo form-edit-modulo" id="editar'+modulos[i].id+'">\n\
                        <fieldset class="form-group">\n\
                            <legend>Editar módulo</legend>\n\
                            <input type="text" name="modulo"> \n\
                            <input type="hidden" name="id" value="'+modulos[i].id+'">\n\
                            <button type="submit" class="btn btn-primary" id="btn-editar">Editar</button> \n\
                        </fieldset>\n\
                    </form>\n\
                </li>'
            );
        console.log("Módulo: "+modulos[i].nome);
    }
    $('.form-edit-modulo').on('submit',editarModulo);
}
function listaAulas(aulas){
    
    $('#lista-aulas'+aulas.id_modulo).html('');
    var url_base = 'http://localhost/ead/painel/aulas/';
    console.log("Tamanho: "+aulas.length);
    console.log("Id Modulo: "+aulas.id_modulo);
    for(var i in aulas){
        $('#lista-aulas'+aulas.id_modulo).append(
                '<li>\n\
                    <span>'+((aulas[i].tipo == 1) ? aulas[i].video.nome : aulas[i].questionario.nome)+'</span>\n\
                    <a href="'+url_base+'editar/'+aulas[i].id+'"><i class="far fa-edit editar"></i></a>\n\
                    <a href="javascript:;" onclick="deleteAula(this)" data-aula-id="'+aulas[i].id+'">\n\
                        <i class="far fa-trash-alt excluir"></i>\n\
                    </a>\n\
                </li>'
            );
        console.log("Aula: "+((aulas[i].tipo == 1) ? aulas[i].video.nome : aulas[i].questionario.nome));
    }
}
function editForm(obj){
    
    var id_modulo = $(obj).attr('data-modulo-id');
    console.log('ID: '+id_modulo);
    if($('#editar'+id_modulo).css('display') == 'none'){
        $('#editar'+id_modulo).show();
    }
    else{
        $('#editar'+id_modulo).hide();
    }

}