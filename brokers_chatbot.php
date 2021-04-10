<?php

add_shortcode("mortgage_broker_chatbot", "mortgage_directory_chat_bot");

function mortgage_directory_chat_bot(){ ?>

	<style type="text/css">
	    #mbd_chatbot{ 
	        position: fixed; 
	        bottom: 5%; 
	        left: 1%; 
	        width: 9%; 
	        height: 5%; 
	        background: transparent; 
	        border: none; }
	    #mbd_chatbot_success{
	        opacity: 0;
	        transition: all .75s ease;
	    }
	    #chatbot_wrap{
	        transition: all .75s ease;
	    }
	    #chatbot_wrap .card-body{
	       
	    }
	    #chatbot_wrap.show #button_toggle{
	        opacity: 0;
	        transition: all .75s ease;
	        margin-top: 109px;
	    }
	    #button_toggle{
	        background: #007bff;
	        border-radius: 30px;
	    }
	    #button_toggle::before{
	        content: '';
	        width: 20px;
	        height: 20px;
	        background: #09f03e;
	        border-radius: 50%;
	        top: -11px;
	        left: 4%;
	        position: absolute;
	        border: 2px solid #fff;
	        z-index: 10000;
	    }
	    #button_toggle::after{ 
	        content: '';
	        border: none;
	    }
	    #message_counter{
	    	position: absolute;
    		top: -8px;
    		right: 0;
	    }
	    #message_counter svg{
	    	width: .7rem;
    		fill: #fff;
	    }
	    #message_counter i{
	    	font-style: normal;
		    color: #fff;
		    font-size: 10px;
		    margin-left: -10px;
		    background: #f00;
		    width: 15px;
		    height: 15px;
		    display: inline-block;
		    border-radius: 50%;
	    }
	    #close_chatbot{ 
	        cursor: pointer;
	        line-height: 2; }
	    #close_chatbot::after{ 
	        content: '';
	        border: none; }
	        #close_chatbot svg{ 
	            fill: #fff;
	            width: 1.425rem; 
	            height: 1.425rem; }
	    .message_wrapper{  height: 400px; overflow-y: scroll; padding-right: 16px; }
	    #message_sent p, #message_reply p, #message_warning p{ 
	        font-size: 12px; }
	    #message_sent small, 
	    #message_reply small,
	    #message_warning small{ 
	        font-size: 10px;
	        display: block;
	        text-align: right; }
	    .typing_animate{ 
	        margin: 0;
	        width: 140px;
	        text-align: center; }
	        .typing_animate small{  
	            margin-right: 5px; }
	        .typing_animate > div{
	            width: 7px;
	            height: 7px;
	            border-radius: 100%;
	            display: inline-block;
	            -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
	            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
	            background: #343a40;
	        }
	        .typing_animate .spin1{
	            -webkit-animation-delay: -0.32s;
	            animation-delay: -0.32s;
	        }
	        .typing_animate .spin2{
	            -webkit-animation-delay: -0.16s;
	            animation-delay: -0.16s;
	        }
	        @-webkit-keyframes sk-bouncedelay {
	          	0%,
	          	80%,
	          	100% {
	            	-webkit-transform: scale(0)
	          	}
	          	40% {
	            	-webkit-transform: scale(1.0)
	          	}
	        }

	        @keyframes sk-bouncedelay {
	          	0%,
	          	80%,
	          	100% {
	            	-webkit-transform: scale(0);
	            	transform: scale(0);
	          	}
	          	40% {
	            	-webkit-transform: scale(1.0);
	            	transform: scale(1.0);
	          	}
	        }

	    @media (max-width: 768px){
	    	#mbd_chatbot{ 
	    		left: auto; 
	    		right: 0;
	    		top: 0; }
	    }

	</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<div class="chatbot_container">
		<div id="mbd_chatbot" class="ui-widget-content">
		    <div class="btn-group dropup" id="chatbot_wrap">
		        <button type="button" id="button_toggle" data-popup="on" class="btn btn-primary dropdown-toggle pl-3" data-toggle="dropdown">Chat <span class="ml-2"><svg style="width: 1.2rem; fill: #fff;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4 32.7 12.3 69 19.4 107.4 19.4 141.4 0 256-93.1 256-208S397.4 32 256 32zM128 272c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm128 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm128 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"/></svg></span>

		        <span id="message_counter">
		        	<svg style="width: .7rem; fill: #fff;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/></svg>
		        	<i>1</i>
		        </span>
		        </button>
		        <div class="dropdown-menu p-0" style="width: 20rem; ">
		            <div class="card border-0">
		                <div class="card-header bg-primary text-white">
		                    <img src="<?php bloginfo("template_url"); ?>/images/broker_img_icon.png" class="img-fluid" style="border-radius: 50%; border: 3px solid #28a745;"> <span class="ml-2">Online</span>

		                    <span class="btn float-right dropdown-toggle" data-toggle="dropdown" id="close_chatbot">
		                        <svg viewBox="0 0 24 24"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path></svg>
		                    </span>
		                </div>
		                <div class="card-body ml-3 p-0">
		                    <div class="message_wrapper pt-2"></div>
		                </div>
		                <div class="card-footer">
		                    <div class="row">
		                        <div class="col-lg-10 px-0">
		                            <input type="text" class="form-control" id="input_type_here" placeholder="Type here..." data-counterid="1" style="height: 38px; font-size: 14px; resize: none;">
		                        </div>
		                        <div class="col-lg-2 px-0">
		                            <button type="button" id="btn_send_chat" class="btn btn-dark">
		                                <span>
		                                    <svg width="57px" height="54px" viewBox="1496 193 57 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 18px; height: 18px;">
		                                        <g id="Group-9-Copy-3" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(1523.000000, 220.000000) rotate(-270.000000) translate(-1523.000000, -220.000000) translate(1499.000000, 193.000000)">
		                                            <path d="M5.42994667,44.5306122 L16.5955554,44.5306122 L21.049938,20.423658 C21.6518463,17.1661523 26.3121212,17.1441362 26.9447801,20.3958097 L31.6405465,44.5306122 L42.5313185,44.5306122 L23.9806326,7.0871633 L5.42994667,44.5306122 Z M22.0420732,48.0757124 C21.779222,49.4982538 20.5386331,50.5306122 19.0920112,50.5306122 L1.59009899,50.5306122 C-1.20169244,50.5306122 -2.87079654,47.7697069 -1.64625638,45.2980459 L20.8461928,-0.101616237 C22.1967178,-2.8275701 25.7710778,-2.81438868 27.1150723,-0.101616237 L49.6075215,45.2980459 C50.8414042,47.7885641 49.1422456,50.5306122 46.3613062,50.5306122 L29.1679835,50.5306122 C27.7320366,50.5306122 26.4974445,49.5130766 26.2232033,48.1035608 L24.0760553,37.0678766 L22.0420732,48.0757124 Z" id="sendicon" fill="#fff" fill-rule="nonzero"></path>
		                                        </g>
		                                    </svg>
		                                </span>
		                            </button>
		                        </div>
		                    </div> 
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>

	<script type="text/javascript">
	
	$(document).ready(function(){

		window.onload = function(){

			// toggle chatbot
			setTimeout(() => { $("#button_toggle").dropdown('toggle'); }, 500);

			chatBotCookie('mbd_chatbot','enabled');

		}

       	// $('#mbd_chatbot').draggable({
        //     cancel: false
        // });

        $("#chatbot_wrap").on("hide.bs.dropdown", function(event){
            if (event.clickEvent) {
                event.preventDefault();
            }

        });

        $("#chatbot_wrap").on("hidden.bs.dropdown", function(event){

        	const get_on = $("#button_toggle").attr("data-popup");
            var show_on = document.querySelector("#message_sent").getAttribute("data-show");

            // const waitTime = 30 * 60 * 1000;

            if(get_on == "on"){
            	setTimeout(() => {
            		$("#button_toggle").dropdown('toggle');
            	}, 10000);
            }

            if(show_on == 1){
            	const mc = document.querySelector("#message_counter");
            	mc.classList.add("d-none");
           	}

            document.querySelector("#button_toggle").setAttribute("data-popup", "off");

        });

        $("#chatbot_wrap").on("shown.bs.dropdown", function(event){
            console.log('shown');
        });

        function getHourMin(){
            var today = new Date();

            hours = today.getHours();
            minute = today.getMinutes();

            var ampm = hours >= 12 ? 'PM' : 'AM';
            if(hours < 10){
                hours = "0" + hours;
            }

            if(minute < 10){
                minute = "0" + minute;
            }

            var time = hours + ":" + minute +""+ ampm.toLowerCase();
            return time;
        }

        function adjustMsgWindow(){
            $(".message_wrapper").animate({
                scrollTop : $(".message_wrapper").prop('scrollHeight')
            })
        }

        function getFirstMsg(){
            $("#btn_send_chat").prop("disabled", true);
            $(".message_wrapper").append('<div class="typing_animate"><small>Agent Typing</small><div class="spin1"></div><div class="spin2"></div><div class="spin3"></div></p>');
            setTimeout(() => {
                $(".message_wrapper").append('<div id="message_sent" class="alert alert-primary float-left" data-show="0"><p class="mb-0 text-dark">Hey can I ask what type of mortgage assistance your looking for?</p><small id="chattime">'+getHourMin()+'</small></div><div class="clearfix"></div>');
                $(".typing_animate").html("");
                $("#btn_send_chat").prop("disabled", false);

            }, 6000);

        }

        getFirstMsg();

        $("#btn_send_chat").click(function(){

            var message = $("#input_type_here").val();
            var counterid = $("#input_type_here").attr("data-counterid");

            if(message == ''){

                $(".message_wrapper").append('<div class="typing_animate"><small>Agent Typing</small><div class="spin1"></div><div class="spin2"></div><div class="spin3"></div></p>');
                setTimeout(() => {
                    $(".message_wrapper").append('<div id="message_warning" class="alert alert-info float-left"><p class="mb-0 text-dark">Oh sorry! Please answer the question correctly.</p><small>'+getHourMin()+'</small></div><div class="clearfix"></div>');
                    $(".typing_animate").html("");
                    adjustMsgWindow();
                }, 3000);


            } else {

                $(".message_wrapper").append('<div id="message_reply" class="alert alert-danger float-right"><p class="mb-0 text-dark">'+message+'</p><small id="chattime">'+getHourMin()+'</small></div><div class="clearfix"></div>');
                document.querySelector("#message_sent").setAttribute("data-show", "1");
                insertChat(counterid);
                adjustMsgWindow();

            }

            $("#input_type_here").val('');

        });

        function chatBotCookie(name, value){
        	// set cookie
			var d = new Date();
            d.setTime(d.getTime() + (30*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            var cookies = name + "=" + value;
            localStorage.setItem(name, value);
            document.cookie = cookies + ";" + expires + ";path=/";
        }

        function disableCookie(){
        	document.cookie = 'mbd_chatbot=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        }

        // this function expect two parameters for ( counter id and broker name )
        function insertChat(counterid){
            var chatMess = [{
                    'chatId': 1,
                    'chatMsg': 'Great! so we actually work with some Top specialists who have over 30 years of experience in getting the best possible deals on this type,  shall I connect you to them as they have access to some exclusive bank deals today, whats your name?',
                    'chatDelay': 9000,
                },
                {
                    'chatId': 2,
                    'chatMsg': 'Great!, and what’s your best contact number or email and I will get this passed on to them now so they can contact you ?',
                    'chatDelay': 7000,
                },
                {
                    'chatId': 3,
                    'chatMsg': 'Great expect contact from them shortly! Thanks again',
                    'chatDelay': 4000,
                }
            ];

            $.each(chatMess, function(index, obj){

                var addOne = 0;
                if(obj.chatId == counterid){

                    $("#btn_send_chat").prop("disabled", true);

                    setTimeout(() => {
                        $(".message_wrapper").append('<div class="typing_animate"><small>Agent Typing</small><div class="spin1"></div><div class="spin2"></div><div class="spin3"></div></p>');
                        adjustMsgWindow();
                    }, 2000);

                    setTimeout(() => {
                        $(".message_wrapper").append('<div id="message_sent" class="alert alert-primary float-right"><p class="mb-0 text-dark">'+obj.chatMsg+'</p><small id="chattime">'+getHourMin()+'</small></div>');
                        $(".typing_animate").html("");
                        

                        // console.log(addOne);
                        addOne = obj.chatId + 1;
                        $("#input_type_here").attr("data-counterid", addOne);

                        if(obj.chatId == 3){
                            $("#btn_send_chat").prop("disabled", true);
                            $("#input_type_here").attr('disabled', 'disabled');

                            // collect of the conversation and convert into an array and pass it to the data ajax request
                            var convo_sent = [];
                            $("#message_sent > p, #message_reply > p").each(function(){
                                convo_sent.push( $(this).text() );
                            });

                            var content_mixed = convo_sent.join('|');
                            
                            // ajax call to insert chatbot conversation
                            $.ajax({
                                type: 'post',
                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                data: {
                                    action: 'save_chatbot_form',
                                    convo: content_mixed
                                },
                                dataType: 'json',
                                success: function(data){
                                    console.log(data);

                                    setTimeout(() => {
                                        $("#button_toggle").dropdown('toggle');
                                    }, 2000);

                                    setTimeout(() => {
                                        $("#mbd_chatbot").attr("id", "mbd_chatbot_success");
                                    }, 5000);

                                    // disable cokie
									disableCookie();

									chatBotCookie('mbd_chatbot_success','enabled');
                                    
                                }
                            });

                        } else {
                            $("#btn_send_chat").prop("disabled", false);
                        }

                        adjustMsgWindow();

                    }, obj.chatDelay);
                }
            });
        }

	});

	</script>

<?php 

}