$(document).ready(function() {
    // Inicializa a validação do formulário
    $('.contact_form').validate({
        rules: {
            nome: 'required',
            email: {
                required: true,
                email: true
            },
            mensagem: 'required',
            'g-recaptcha-response': 'required' // Adiciona regra para o reCAPTCHA
        },
        messages: {
            nome: 'Por favor, insira seu nome',
            email: {
                required: 'Por favor, insira seu endereço de e-mail',
                email: 'Por favor, insira um endereço de e-mail válido'
            },
            mensagem: 'Por favor, insira sua mensagem',
            'g-recaptcha-response': 'Por favor, complete o reCAPTCHA' // Mensagem para o reCAPTCHA
        },
        submitHandler: function(form) {
            // Este código será executado quando o formulário for submetido com sucesso
            form.submit();
        }
    });
});
