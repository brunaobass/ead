var url_base = 'http://localhost/ead/modulos/';
var mouse_over = false;
var locked = true;

$(document).ready(function(){
    
    $('#btn-perfil').click(function(){
        $('.menu-logado').toggle(300);
    });
    $('#btn-show-menu').click(function(){
        $('.menu-navegacao').show(300);
        $('#btn-close-menu').show();
        $(this).hide();
      
    });
    $('#btn-close-menu').click(function(){
        $('.menu-navegacao').hide(300);
        $(this).hide();
        $('#btn-show-menu').show();
        
    });
    
    $('.input-alternativa').keypress(function(e){
        if(e.which == 13){
            e.preventDefault();
        }
    });
    $('.input-alternativa').click(function(){
        
        $(this).select();   
        var input = $(this);        
        preencheCampoVazio(input);
        
    });

    $('.btn-check-aula').hover(
            function(){                
                checkUncheck($(this));
            },
            function(){
                if(!locked){
                    locked = true;
                }else{
                    checkUncheck($(this));
                }
            }
        );    
});
function preencheCampoVazio(input){
    var alternativa = input.val();
    var noBlur = false;
    
    input.on('blur',function(){
        if(!noBlur){
            noBlur = true;
            if(input.val() == ''){                
                input.val(alternativa) ;
            }
        }        
    });
}

function concluirAula(obj){
    var id = $(obj).attr('data-id');
    marcarAssistido(id);
    $(obj).remove();
}

function marcarAssistido(id){
        
    $.ajax({
        url:'http://localhost/ead/ajax/marcar_assistido',
        type:'POST',
        data:{id:id},
        success:function(){
        }
    });    
}

function desmarcarAssistido(id){
 
    $.ajax({
        url:'http://localhost/ead/ajax/desmarcar_assistido',
        type:'POST',
        data:{id:id},
        success:function(){
        }
    });    
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

$('#btn-troca-foto').on('click',function(){
    $('#input-foto').trigger('click');
});

function trocaFoto(){
    if(typeof(FileReader) != "undefined"){
        var img_preview = $('#img_preview');      
        var reader = new FileReader();

        reader.onload = function(e){
            img_preview.attr('src',e.target.result);
        }
        
        reader.readAsDataURL($('#input-foto')[0].files[0]);
    }
    else{
            alert("Este navegador não suporta FileReader.");
	}
}

function editarModulo(e){
  
  e.preventDefault();
  var dados = $(this).serialize(); 
  var url_base = 'http://localhost/ead/modulos/';
  
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
            console.log("Erro encontrado: "+errorThrown);
        }
    });
}

function deleteAula(obj){
    var id_aula = $(obj).attr('data-aula-id');
    var url_base = 'http://localhost/ead/aulas/';
    $.ajax({
        url:url_base+'deletar',
        type:'POST',
        data:{id:id_aula},
        dataType:'json',
        success:function(json){
            listaAulas(json);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Erro encontrado: "+errorThrown);
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
                        <a href="javascript:;" onclick="excluirQuestao(this)" class="btn-excluir-alternativa"\n\
                            data-id-questao ="'+id_questao+'">\n\
                            <i class="far fa-trash-alt excluir"></i>\n\
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
               '<li class="form-group li-alternativa" id="quest'+id_questao+'alt'+i+'">\n\
                    <input type="radio" name="resposta-questao'+id_questao+'" value="'+i+'"\n\
                        '+((i==1) ? 'checked="checked"' : '')+'>\n\
                    <input type="text" name="quest'+id_questao+'-alt'+i+'" class="input-alternativa" \n\
                        value="Opção '+i+'">\n\
                    <input type="hidden" name="id-quest'+id_questao+'-alt'+i+'" value="'+i+'">\n\
                </li>'; 
        
        $('#opcoes-questao'+id_questao).append(html_alternativas);
    }
    
    $('input[name="id-ultima-questao"]').val(id_questao);
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
    preencheCampoVazio(input);
    
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
    preencheCampoVazio(input);
    
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
function excluirQuestao(obj){

    var id_questao = $(obj).attr('data-id-questao');
    var parent = $(obj).parent();
    var input = $(obj).parent().find('[type="text"]');
    
    var html = '<input type="hidden" name="id-delete'+id_questao+'" value="'+id_questao+'">';
    parent.append(html);
    parent.parent().hide();
    
    input.select();
    preencheCampoVazio(input);
    
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
    preencheCampoVazio(input);
    
    var noBlur = false;
    input.blur(function(){
        if(!noBlur){
            noBlur = true;
            alternativa.html(input.val());
            
            alternativa.show();
            $(obj).show();
            input.hide();
        }
    });
}
function checkAula(obj){
    var elemento = $(obj);
    var id = elemento.attr('data-id-aula');

    if(locked){
        locked = false;
             
    }else{
        checkUncheck(elemento);
    }
    
    
    $.ajax({
        url:'http://localhost/ead/ajax/verifica_assistido',
        type:'POST',
        data:{id:id},
        success:function(resultado){

            if(resultado){
                desmarcarAssistido(id);
            }
            else{
                marcarAssistido(id);
            }
        }
    });
    
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

    }
    $('.form-edit-modulo').on('submit',editarModulo);
}
function listaAulas(aulas){
    
    $('#lista-aulas'+aulas.id_modulo).html('');
    var url_base = 'http://localhost/ead/aulas/';

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
    }
}
function editForm(obj){
    
    var id_modulo = $(obj).attr('data-modulo-id');

    if($('#editar'+id_modulo).css('display') == 'none'){
        $('#editar'+id_modulo).show();
    }
    else{
        $('#editar'+id_modulo).hide();
    }

}

function checkUncheck(elemento){
    if(elemento.hasClass('checked')){
        elemento.removeClass('checked');
        elemento.addClass('not-checked');
      }

      else if(elemento.hasClass('not-checked')){
          elemento.removeClass('not-checked');
          elemento.addClass('checked');
      }
}