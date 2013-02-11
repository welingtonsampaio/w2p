/**
 * 
 */
jQuery(window).ready(function(){

	// Define variáveis ​​globais e elementos de cache DOM para reutilização posterior
    var form = jQuery('#form').find('form'),
    formElements = form.find('input[type!="submit"],textarea'),
    formSubmitButton = form.find('[type="submit"]'),
    errorNotice = jQuery('#errors'),
    successNotice = jQuery('#success'),
    loading = jQuery('#loading'),
    errorMessages = {
            required: ' é um campo obrigatório',
            email: 'Você precisa fornecer um email válido para este campo: ',
            minlength: ' deve ser maior que '
    };
	
	//função detecção + polyfills
	formElements.each(function(){

          //Se o atributo HTML5 placeholder  não é suportado pelo Browser
          if(!Modernizr.input.placeholder){
            var placeholderText = this.getAttribute('placeholder');
            if(placeholderText){
              jQuery(this)
                .addClass('placeholder-text')
                .val(placeholderText)
                .bind('focus',function(){
                  if(this.value == placeholderText){
                    jQuery(this)
                      .val('')
                      .removeClass('placeholder-text');
                  }
                })
                .bind('blur',function(){
                  if(this.value == ''){
                    jQuery(this)
                      .val(placeholderText)
                      .addClass('placeholder-text');
                  }
                });
            }
          }
		
          //Se o atributo HTML5 autofocus não é suportado pelo Browserd
          if(!Modernizr.input.autofocus){
            if(this.getAttribute('autofocus')) this.focus();
          }
		
	});
	
        // para garantir a compatibilidade com os fomrs HTML5, temos que validar o formulário pelo evento click do botão submit ao invés de evento de envio do formulário.
	formSubmitButton.bind('click',function(){
		var formok = true,
			errors = [];
			
		formElements.each(function(){
			var name = this.name,
                        nameUC = name.ucfirst(),
                        value = this.value,
                        placeholderText = this.getAttribute('placeholder'),
                        type = this.getAttribute('type'), //get type old school way
                        isRequired = this.getAttribute('required'),
                        minLength = this.getAttribute('data-minlength');
			
			//se formfields HTML5 são suportados		
			if( (this.validity) && !this.validity.valid ){
				formok = false;
				
				console.log(this.validity);
				
				//if there is a value missing
				if(this.validity.valueMissing){
					errors.push(nameUC + errorMessages.required);	
				}
				//if this is an email input and it is not valid
				else if(this.validity.typeMismatch && type == 'email'){
					errors.push(errorMessages.email + nameUC);
				}
				
				this.focus(); //safari does not focus element an invalid element
				return false;
			}
			
			//se for um elemento required
			if(isRequired){	
                          //Se input required HTML5  não é suportado pelo Browser
                          if(!Modernizr.input.required){
                            if(value == placeholderText){
                                    this.focus();
                                    formok = false;
                                    errors.push(nameUC + errorMessages.required);
                                    return false;
                            }
                          }
			}

			//Se input email HTML5  não é suportado pelo Browser
			if(type == 'email'){ 	
                          if(!Modernizr.inputtypes.email){ 
                            var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
                            if( !emailRegEx.test(value) ){	
                                    this.focus();
                                    formok = false;
                                    errors.push(errorMessages.email + nameUC);
                                    return false;
                            }
                          }
			}
			
                  //verifica o número mínimo de caracteres
                  if(minLength){
                    if( value.length < parseInt(minLength) ){
                      this.focus();
                      formok = false;
                      errors.push(nameUC + errorMessages.minlength + minLength + ' caracteres');
                      return false;
                    }
                  }
		});
		
		//se o formulário não é válido
		if(!formok){

                  jQuery('#req-field-desc')
                      .stop()
                      .animate({
                        marginLeft: '+=' + 5
                      },150,function(){
                        jQuery(this).animate({
                                marginLeft: '-=' + 5
                        },150);
                      });

                //mostra a mensagem de erro
                showNotice('error',errors);
			
		}
		//se é válido
		else {
                  loading.show();
                  jQuery.ajax({
                      url: form.attr('action'),
                      type: form.attr('method'),
                      data: form.serialize(),
                      success: function(){
                              showNotice('success');
                              form.get(0).reset();
                              loading.hide();
                      }
                  });
		}
		
		return false;
		
	});

	//outras funções helpers
	function showNotice(type,data)
	{
          if(type == 'error'){
                  successNotice.hide();
                  errorNotice.find("li[id!='info']").remove();
                  for(x in data){
                          errorNotice.append('<li>'+data[x]+'</li>');	
                  }
                  errorNotice.show();
          }
          else {
                  errorNotice.hide();
                  successNotice.show();	
          }
	}
	
	String.prototype.ucfirst = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	};
	
});