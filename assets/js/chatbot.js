(function ($) {
    'use strict';

    const botResponses = [
        'Great! We work with specialists who have over 30 years of experience in getting the best possible deals on this type. Shall I connect you to them now?',
        'Great! And what is your best contact number or email? I will pass this on to them now so they can contact you.',
        'Great! Expect contact from them shortly. Thanks again.'
    ];

    let botStep = 0;

    function getHourMin() {
        const now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        const suffix = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12;
        hours = String(hours).padStart(2, '0');
        minutes = String(minutes).padStart(2, '0');

        return hours + ':' + minutes + suffix.toLowerCase();
    }

    function appendTyping() {
        const typing = $('<div class="typing_animate"><small>' + wpSimpleChatbot.strings.agentTyping + '</small><div class="spin1"></div><div class="spin2"></div><div class="spin3"></div></div>');
        $('.message_wrapper').append(typing);
        adjustMsgWindow();
        return typing;
    }

    function adjustMsgWindow() {
        const wrapper = $('.message_wrapper');
        wrapper.stop(true, true).animate({
            scrollTop: wrapper.prop('scrollHeight')
        }, 200);
    }

    function appendMessage(role, text) {
        const cssClass = role === 'user' ? 'alert-danger float-right' : 'alert-primary float-left';
        const id = role === 'user' ? 'message_reply' : 'message_sent';

        const alert = $('<div>', {
            id: id,
            class: 'alert ' + cssClass,
            'data-show': '0'
        });

        alert.append($('<p>', { class: 'mb-0 text-dark' }).text(text));
        alert.append($('<small>', { id: 'chattime', text: getHourMin() }));

        $('.message_wrapper').append(alert);
        adjustMsgWindow();
    }

    function buildConversation() {
        const messages = [];

        $('.message_wrapper .alert').each(function () {
            const text = $(this).find('p').text().trim();
            if (text) {
                messages.push(text);
            }
        });

        return messages;
    }

    function finalizeConversation() {
        const conversation = buildConversation();

        $.ajax({
            type: 'POST',
            url: wpSimpleChatbot.ajaxUrl,
            data: {
                action: 'wp_simple_chatbot_save',
                nonce: wpSimpleChatbot.nonce,
                convo: JSON.stringify(conversation)
            },
            dataType: 'json',
            success: function (response) {
                if (response && response.success) {
                    setTimeout(function () {
                        $('#button_toggle').trigger('click');
                    }, 2000);
                }
            },
            error: function () {
                // Intentionally left silent; the UI remains usable.
            }
        });
    }

    function showWarning() {
        const typing = appendTyping();

        setTimeout(function () {
            typing.remove();
            appendMessage('bot', wpSimpleChatbot.strings.emptyMessage);
            adjustMsgWindow();
        }, 2000);
    }

    function handleBotReply() {
        if (botStep >= botResponses.length) {
            finalizeConversation();
            return;
        }

        const typing = appendTyping();
        const responseText = botResponses[botStep];

        setTimeout(function () {
            typing.remove();
            appendMessage('bot', responseText);
            botStep += 1;
            $('#btn_send_chat').prop('disabled', false);
            $('#input_type_here').focus();

            if (botStep >= botResponses.length) {
                finalizeConversation();
            }
        }, 2000);
    }

    function initializeConversation() {
        const intro = $('<div>', {
            id: 'message_sent',
            class: 'alert alert-primary float-left',
            'data-show': '0'
        });

        intro.append($('<p>', {
            class: 'mb-0 text-dark',
            text: 'Hey can I ask what type of mortgage assistance you are looking for?'
        }));
        intro.append($('<small>', { id: 'chattime', text: getHourMin() }));
        $('.message_wrapper').append(intro);
    }

    $(document).ready(function () {
        initializeConversation();

        $('#btn_send_chat').on('click', function () {
            const message = $('#input_type_here').val().trim();

            if (!message) {
                showWarning();
                return;
            }

            $('#btn_send_chat').prop('disabled', true);
            appendMessage('user', message);
            $('#input_type_here').val('');
            handleBotReply();
        });

        $('#input_type_here').on('keydown', function (event) {
            if (event.key === 'Enter') {
                $('#btn_send_chat').trigger('click');
            }
        });

        $('#close_chatbot').on('click', function () {
            $('#chatbot_wrap').removeClass('show');
        });
    });
})(jQuery);
