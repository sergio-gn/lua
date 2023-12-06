jQuery(document).ready(function ($) {
    $('.vote-button, .reset-vote').on('click', function (e) {
        e.preventDefault();

        var button = $(this);

        // Verificar se o usuário está logado
        if (!is_user_logged_in()) {
            console.log('Você precisa estar logado para votar.');
            return;
        }

        // Verificar se o usuário já votou
        if (has_user_voted(button.data('post-id'))) {
            console.log('Você já votou nesta postagem.');
            return;
        }

        // Se o botão estiver sendo processado, ignore o clique
        if (button.hasClass('processing')) {
            return;
        }

        // Ative a flag de processamento
        button.addClass('processing');

        console.log('Botão clicado');

        var postId = button.data('post-id');
        var voteType = 'reset';

        if (button.hasClass('vote-up')) {
            voteType = 'upvote';
        } else if (button.hasClass('vote-down')) {
            voteType = 'downvote';
        }

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'handle_vote',
                post_id: postId,
                vote_type: voteType,
            },
            success: function (response) {
                console.log('Resposta AJAX:', response);

                if (response.success) {
                    var voteCount = response.data.vote_count;
                    $('.voting-info[data-post-id="' + postId + '"] .vote-count').text(voteCount);

                    // Registre que o usuário votou nesta postagem
                    set_user_voted(postId);
                } else {
                    console.log('Erro na solicitação AJAX.');
                }
            },
            error: function (error) {
                console.log('Erro na solicitação AJAX:', error);
            },
            complete: function () {
                // Desative a flag de processamento após a conclusão, independentemente de sucesso ou erro
                button.removeClass('processing');
            }
        });
    });

    // Função para verificar se o usuário está logado
    function is_user_logged_in() {
        return typeof userLoggedIn !== 'undefined' && userLoggedIn;
    }

    // Função para verificar se o usuário já votou usando cookies padrão do JavaScript
    function has_user_voted(postId) {
        var votedPosts = get_user_voted_posts();
        return votedPosts.indexOf(postId) !== -1;
    }

    // Função para obter os IDs das postagens que o usuário votou
    function get_user_voted_posts() {
        var votedPosts = document.cookie.replace(/(?:(?:^|.*;\s*)votedPosts\s*\=\s*([^;]*).*$)|^.*$/, "$1");
        return votedPosts ? votedPosts.split(',') : [];
    }

    // Função para definir que o usuário votou em uma postagem usando cookies padrão do JavaScript
    function set_user_voted(postId) {
        var votedPosts = get_user_voted_posts();
        votedPosts.push(postId);

        // Definir o cookie com a nova lista de postagens votadas
        document.cookie = "votedPosts=" + votedPosts.join(',') + "; path=/";
    }
});
