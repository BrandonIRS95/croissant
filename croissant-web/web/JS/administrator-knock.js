var URL_SERVER = "http://localhost/croissant/";


function Conference(id, title, type, description, date, time, place, room) {
    var self = this;
    self.id = id;
    self.title = title;
    self.type = type;
    self.description = description;
    self.date = date;
    self.time = time;
    self.place = place;
    self.room = room;
}

function EventObj(id, name, description, logo, theme, admin)
{
    var self = this;
    self.id = ko.observable(id);
    self.name = ko.observable(name);
    self.description = ko.observable(description);
    self.logo = logo;
    self.theme = theme;
    self.admin = ko.observable(admin);
}

function closeModal()
{
    $("#conteiner-add-conference").remove();
    $(".jquery-modal").remove();
    $(".xdsoft_datetimepicker").remove();
}


var vm = function AdministrationViewModel() {
    var self = this;
    
    self.getConferences = function() {
        
        var data = { txtnickname : "1", id_event: localStorage.getItem("idevent")};
        
        $.post(URL_SERVER + "getconferences.php", data, function(returnedData) {

            var jsonData = JSON.parse(returnedData);
            
            var mappedConferences = $.map(jsonData.conferences, function(item) {
                return new Conference(item.id, item.title, item.type, item.description, item.date, item.time, item.place, item.room);
            });
            
            self.conferences(mappedConferences);
            
            $('.grid').masonry({
              itemSelector: '.grid-item'
            });

        });
    };
    
    self.showAddElement = function() {
        $.get("template-add-conference.html", null, function(returnedData){
            
                $($.parseHTML(returnedData)).appendTo("body").modal({
                    escapeClose: false,
                    clickClose: false,
                    showClose: false
                });

                $('#conference-date').datetimepicker({
                    timepicker:false,
                    format:'Y/m/d'
                });

                $('#conference-time').datetimepicker({
                    datepicker:false,
                    format: 'H:i'
                });
            
                $("#close-modal").click(function(){
                    closeModal();    
                });

                autosize($('#event-description'));

                $("#form-add-conference").validate({
                    rules: {
                        title: {
                            required: true
                        },
                        place: {
                            required: true
                        },
                        room: {
                            required: true
                        },
                        date: {
                            required: true,
                            date: true
                        },
                        time: {
                            required: true,
                            time: true
                        },
                        type: {
                            required: true
                        },
                        description: {
                            required: false
                        }
                    },
                    submitHandler: function(form) {
                        var data = $("#form-add-conference").serializeArray();
                        data.push({ name: "idevent", value: localStorage.getItem("idevent") });
                        
                        $.ajax({
                           type: "POST",
                           url: URL_SERVER + 'addconference.php',
                           data: data
                        }).done(function(result){
                            
                            var item = JSON.parse(result);
                            
                            self.conferences.push(new Conference(item.id, item.title, item.type, item.description, item.date, item.time, item.place, item.room));
                            
                            $('.grid').masonry("destroy");
                            $('.grid').masonry({
                              itemSelector: '.grid-item'
                            });
                            
                            closeModal();
                        });
                    }
                });
            });
    };

    self.eventObj = new EventObj("","","","","","");
    
    self.showInfo = function() {
        
        var data = { id: localStorage.getItem("idevent") };

        $.get(URL_SERVER + "getEvent.php", data, function(returnedData){

            var jsonResult = JSON.parse(returnedData);
            self.setEventInfo(jsonResult);
            
            $("#conteiner-event-logo").append($.parseHTML('<img src="../web/upload/' + jsonResult.logo + '" />'));
            
            self.setTheme(jsonResult.theme);
            
            $("body").css("display", "inline");
            
        });
        
        $("#user-name").html(localStorage.getItem("moderatorname"));

    };
    
    self.showInfoEvent = function()
    {
        $.get("template-event.html", null, function(returnedData){
            
            var $panelView = $("#panel-view");
            
            $("#add-button").css("display", "none");
            
            $panelView.html(returnedData);
            
            autosize($('#event-description'));
            
            showColors();
            
            setColors(self.eventObj.theme.primary_dark, self.eventObj.theme.ascent);
            
            $("#conteiner-logo").append("<img src='upload/" + self.eventObj.logo + "'/>");

            ko.cleanNode($panelView[0]);
            
            ko.applyBindings(null, $panelView[0]);
            
            ko.cleanNode($("#event-name")[0]);
            
            $(".form-color-item").on("click", selectColors);
            
            $('#conteiner-logo').click(function(){
                
                $('#file').trigger('click');
                
            });
            
            
            $("#file").change(function(){
                
                self.removeLogo();
                self.uploadLogo();
                
            });
            
            $('#form-edit-event').validate({
                ignore: "",
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    filename: {
                        required: true
                    },
                    eventPrimaryColor: {
                        required: true
                    },
                    eventAccentColor: {
                        required: true
                    }
                },
                messages: {
                    filename: {
                        required: 'Please, upload an logo.'
                    },
                    eventPrimaryColor: {
                        required: 'Please, select the primary color.'
                    },
                    eventAccentColor: {
                        required: 'Please, select the accent color.'
                    }
                },
                submitHandler: function(form) {
                    
                    self.updateTheme().done(function(data){
                        
                        var jsonResult = JSON.parse(data);
                        
                        self.updateEvent(jsonResult.id).done(function(data){
                            
                            var resultJson = JSON.parse(data);
                            self.setEventInfo(resultJson);
                            
                        });
                    });
                }
            });
            
        }); 
    };
    
    self.setEventInfo = function(jsonResult)
    {
        var event = self.eventObj;
        event.id(jsonResult.id);
        event.name(jsonResult.name);
        event.description(jsonResult.description);
        event.logo = jsonResult.logo;
        event.theme = jsonResult.theme;
        event.admin(localStorage.getItem("idadmin"));
    }
    
    self.setTheme = function(theme)
    {        
        var style = '<style> .primary-color { background: '+ theme.primary_dark + ';}\
            .text-accent{ color: ' + theme.primary + '}\
            .text-input:focus { box-shadow: 0 2px 0 ' + theme.primary +';} </style>';
        
        $("#add-button").attr("fill", theme.ascent);
        
        $("head").append(style);
        
    };
    
    self.uploadLogo = function()
    {
        var ajax = new XMLHttpRequest();
        var data = new FormData();
        
        data.append("file", document.querySelector("#file").files[0]);
        data.append("eventid", self.eventObj.id());

        ajax.onreadystatechange=function(e) {

            if(ajax.status==200 && ajax.readyState == 4) {

                    var $logoConteiner = $("#conteiner-logo");

                    var jsonResult = JSON.parse(ajax.responseText);

                    $("#event-image").val(jsonResult.name);

                    $("#event-image-error").remove();

                    $logoConteiner.css("background", "transparent");

                    $logoConteiner.html("<img src='" + jsonResult.src + "'/>");

                    self.eventObj.logo = jsonResult.name;
                }
        }

        ajax.open("POST", URL_SERVER + "upload.php");
        ajax.send(data);
    };
    
    self.removeLogo = function()
    {
        return $.ajax({
          url: URL_SERVER + "removeImage.php",
          type: "POST",
          data: {imgname : self.eventObj.logo }
        });
    };
    
    self.showConferences = function() {
        
        $("#panel-view").empty();
        $("#add-button").css("display", "inline");
    };
    
    self.updateTheme = function()
    {
        var primaryPosition = $("#event-primary-color").val();
        var accentPosition = $("#event-accent-color").val();
        var primaryColors = COLORS[primaryPosition].colors;
        var accentColors = COLORS[accentPosition].colors;
        
        return $.ajax({
          url: URL_SERVER + "updateTheme.php",
          type: "POST",
          data: { 
              dark : primaryColors[0],
              primary : primaryColors[1],
              light : primaryColors[2],
              text : primaryColors[3],
              ascent : accentColors[0],
              id : self.eventObj.theme.id
          }
        });
    };
    
    self.updateEvent = function()
    {
        var eventData = $("#form-edit-event").serializeArray();

        eventData.push({ name: "idTheme", value: self.eventObj.theme.id });
        eventData.push({ name: "adminid", value: localStorage.getItem("idadmin")});
        eventData.push({ name: "eventid", value: self.eventObj.id});
        eventData.push({ name: "filename", value: self.eventObj.logo});
        
        return $.ajax({
           type: "POST",
           url: URL_SERVER + 'updateEvent.php',
           data: eventData
        });
    };
    
    self.conferences = ko.observableArray([]);
    self.showInfo();
    self.getConferences();
    
}
/*ko.utils.domNodeDisposal.cleanExternalData = function () {
    // Do nothing. Now any jQuery data associated with elements will
    // not be cleaned up when the elements are removed from the DOM.
};*/
ko.applyBindings(vm);