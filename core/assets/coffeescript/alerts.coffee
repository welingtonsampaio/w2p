class W2P_Message
	@index = 0
	@idAlert = "#alerts"
	@intervalTime = 3500
	constructor: (html, type="")->
		Alerts = jQuery @idAlerts
		Alerts.append "<div class=\"alert #{type} alert-#{@getIndex()}\"><button type=\"button\" class=\"close close-#{@getIndex()}\" data-dismiss=\"alert-#{@getIndex()}\">×</button><strong>Well done!</strong>#{html}</div>"
		jQuery(".close-#{@getIndex()}").click ->
			jQuery(".#{this.dataset.dismiss}").alert 'close'