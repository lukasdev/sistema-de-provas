$(function(){
    var provaId = 0;
    $('.open-prova').on('click', function(e){
        e.preventDefault();
        $('#next, #prev, .begin, .timer').show();
        provaId = $(this).attr('data-id');
        $('.questoes').html('');

        $.ajax({
            method:'POST',
            url: 'sys/getProva.php',
            dataType: 'json',
            data: {prova: provaId},
            success:function(r){
                $('#wrap-prova h1').html(r.titulo);
                //console.log(r.questoes);
                $.each(r.questoes, function(){
                    var questao = this;
                    var html = '<div class="questao">';
                        html += '<h2>'+questao.questao+'</h2>';
                        if (questao.tipo == 0) {
                            $.each(questao.opcoes, function(){
                                var opcao = this;
                                html += '<p><input type="radio" class="resposta" name="resposta'+questao.id+'" value="'+opcao.id+'"/> '+opcao.opcao+'</p>';
                            });
                        } else {
                            html += '<input type="text" name="resposta'+questao.id+'" />';
                        }
                        html+= '</div>';
                    $('.questoes').append(html);
                });
            }
        });
        return false;
    });

    var iterator = 0;

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
});