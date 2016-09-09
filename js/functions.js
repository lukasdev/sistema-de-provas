$(function(){
    var provaId = 0;
    var iniciada = 0;
    var tempoSegundos = 0;
    var iterator = 0;
    var provaAtual;
    var timer;


    function submeteProva(){
        var respostas = {};
        if ($('#concluir').length  > 0) {

            $('#concluir').removeClass('azul');
            $('#concluir').text('Próxima');
            $('#concluir').attr('id', 'next');
        }

        $.each(provaAtual.questoes, function(){
            var questao = this;
            if (questao.tipo == 0) {
                var campo = $('input[name=resposta'+questao.id+'].escolhido');
                if(campo.length >= 1) {
                    respostas[questao.id] = campo.val();
                } else {
                    respostas[questao.id] = '';
                }
                
            } else {
                respostas[questao.id] = $('input[name=resposta'+questao.id+']').val();
            }
        });

        $.ajax({
            method: 'POST',
            url: 'sys/submeteProva.php',
            data: {
                prova: provaId,
                respostas: respostas
            },
            success: function(r){

            }
        });

        iniciada = 2;
        $('.sucesso').fadeIn();
        $('.prova'+provaId).remove();
        clearInterval(timer);
    }

    $('.open-prova').on('click', function(e){
        e.preventDefault();
        if (iniciada == 1) {
            alert('Conclua a prova atual!');
        } else {
            $('#next, #prev, .begin, .timer').show();
            $('.timer').removeClass('danger');
            iterator = 0;
            iniciada = 0;
            provaId = $(this).attr('data-id');
            $('.questoes').html('');
            $('.sucesso').hide();

            $.ajax({
                method:'POST',
                url: 'sys/getProva.php',
                dataType: 'json',
                data: {prova: provaId},
                success:function(r){
                    provaAtual = r;
                    tempoSegundos = r.tempo*60;
                    var tempo = converteEmTempo(tempoSegundos);
                    $('.timer').html(tempo);

                    $('#wrap-prova h1').html(r.titulo);
                    //console.log(r.questoes);
                    $.each(r.questoes, function(){
                        var questao = this;
                        var html = '<div class="questao">';
                            html += '<h2>'+questao.questao+'</h2>';
                            if (questao.tipo == 0) {
                                $.each(questao.opcoes, function(){
                                    var opcao = this;
                                    html += '<p><input type="radio" class="resposta radio" name="resposta'+questao.id+'" value="'+opcao.id+'"/> '+opcao.opcao+'</p>';
                                });
                            } else {
                                html += '<input type="text" name="resposta'+questao.id+'" />';
                            }
                            html+= '</div>';
                        $('.questoes').append(html);
                    });
                }
            });
        }
        return false;
    });

    //escolha de resposta input radio
    $('body').on('click', '.radio', function(e){
        var name = $(this).attr('name');
        $('input[name='+name+']').removeClass('escolhido');
        $(this).addClass('escolhido');
    });  

    $('body').on('click', '#next', function(e){
        e.preventDefault();
        iterator++;
        var qtdQuestoes = ($('.questao').length-1);
        if (iterator == qtdQuestoes) {
            $(this).attr('id', 'concluir');
            $(this).addClass('azul');
            $(this).text('Concluir')
        }

        $('.questao').hide();
        $('.questao:eq('+iterator+')').show();
        return false;
    });

    $('body').on('click', '#prev', function(e){
        e.preventDefault();
        var qtdQuestoes = ($('.questao').length-1);
        if (iterator == qtdQuestoes) {
            $('#concluir').removeClass('azul');
            $('#concluir').text('Próxima');
            $('#concluir').attr('id', 'next');
        }
        iterator--;
        if (iterator < 0) {
            iterator = 0;
        }

        $('.questao').hide();
        $('.questao:eq('+iterator+')').show();
        return false;
    });


    //concluir prova
    $('body').on('click', '#concluir', function(e){
        e.preventDefault();
        submeteProva();

        return false;
    });

    //Procedimento para iniciar a prova
    $('#comecar').on('click', function(e){
        e.preventDefault();
        iniciada = 1;
        $('.begin').fadeOut();

        timer = setInterval(function(){
            tempoSegundos--;
            if (tempoSegundos <= 60) {
                $('.timer').addClass('danger');
            }

            $('.timer').html(converteEmTempo(tempoSegundos));
            if (tempoSegundos == 0) {
                submeteProva();
            }
        }, 1000);

        return false;
    });
});