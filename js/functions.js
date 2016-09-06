$(function(){
    var provaId = 0;
    $('.open-prova').on('click', function(e){
        e.preventDefault();
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
});