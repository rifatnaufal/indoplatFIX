var nambah = parseInt(document.getElementById('number').value);
            
            function hariIni(){
                document.getElementById("div2").innerHTML = ""; 
                nambah = 0;                
                document.getElementById('number').value = nambah;
                buatMinggu(nambah);
                $(document).ready(function(){
                    
                    var xhttp;
                    xhttp = new XMLHttpRequest(); 
                    xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(this.responseText, "text/html");
                        var elem = doc.getElementById("div1");
                    $("#div2").append(elem.innerHTML);
                    }
                }
                    xhttp.open("GET", "getTampil.php?q="+$("#getHari1").attr("value") + "/" + $("#getHari6").attr("value"), true);
                    xhttp.send();

                    var table= document.getElementById("fetchTabel");
           
                    for(var i = 1; i < table.rows[0].cells.length-1; i ++) {    
                        console.log(i)     
                        var day = moment().format("YYYY-MM-DD")
                        var getHariMasingMasing = document.getElementById("getHari"+(i)).getAttribute("value")
                        
                        console.log(getHariMasingMasing)
                        console.log(day)
                        if (getHariMasingMasing==day) {
                            var elem = $('#kolom'+i);                          
                            if(!elem.hasClass('warnainTH')){
                            elem.addClass('warnainTH');
                            }
                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(!elem1.hasClass('warnainShift')){
                                elem1.addClass('warnainShift');
                                }
                            }

                        } else{

                            var elem = $('#kolom'+i);                          
                            if(elem.hasClass('warnainTH')){
                            elem.removeClass('warnainTH');
                            }


                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(elem1.hasClass('warnainShift')){
                                elem1.removeClass('warnainShift');
                                }
                                console.log('#kolom'+i+'shift'+e);
                            }
                        }
                    }
                    
                });
            }
            
            function buatMinggu(nambah) {
                //reset div
                for (let index = 1; index < 7; index++) {
                    document.getElementById("kolom"+index).innerHTML = ""; 
                }
                 

                //initialize hari
                const hari = moment().locale("id");
                const coba = hari.add(nambah,'days');  
                const cobaMinggu =coba.startOf('Week');

                //buat div hari 2-6
                for (let index = 1; index < 7; index++) {
                    var divCoba = document.createElement("DIV"); 
                    
                    var mingguMasuk=cobaMinggu.add(1,'days').format("YYYY-MM-DD");
                    var hariMasuk=cobaMinggu.format("dddd");
                    var warnaHariIni = document.createAttribute("style");
                    var idHari = document.createAttribute("id"); 
                    var valueHari = document.createAttribute("value");    
                    if (mingguMasuk==(moment().locale("id").format("YYYY-MM-DD"))) {                       
                        warnaHariIni.value = "color: #ffb048;";                                     
                    }else{
                        warnaHariIni.value = "";
                    }
                    valueHari.value=mingguMasuk;  
                    idHari.value="getHari"+(index);  
                    divCoba.setAttributeNode(valueHari);
                    divCoba.setAttributeNode(idHari);
                    divCoba.setAttributeNode(warnaHariIni);
                    divCoba.innerHTML = hariMasuk+"<br>"+mingguMasuk;
                    document.getElementById("kolom"+index).append(divCoba);  
                    
                    //console logging value getHari
                    console.log(document.getElementById("getHari"+index).getAttribute('value'));                                             
                } 

            }
            buatMinggu(nambah);
            

            
            function incrementValue()
            {
                document.getElementById("div2").innerHTML = ""; 
                var nambah = parseInt(document.getElementById('number').value);
                nambah = isNaN(nambah) ? 0 : nambah;
                console.log(nambah);
                nambah+=7;
                document.getElementById('number').value = nambah;
                buatMinggu(nambah);
                
                $(document).ready(function(){
                    var xhttp;
                    xhttp = new XMLHttpRequest(); 
                    xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(this.responseText, "text/html");
                        var elem = doc.getElementById("div1");
                    $("#div2").append(elem.innerHTML);
                    }
                }
                    xhttp.open("GET", "getTampil.php?q="+$("#getHari1").attr("value") + "/" + $("#getHari6").attr("value"), true);
                    xhttp.send();




                    var table= document.getElementById("fetchTabel");
           
                    for(var i = 1; i < table.rows[0].cells.length-1; i ++) {    
                        console.log(i)     
                        var day = moment().format("YYYY-MM-DD")
                        var getHariMasingMasing = document.getElementById("getHari"+(i)).getAttribute("value")
                        
                        console.log(getHariMasingMasing)
                        console.log(day)
                        if (getHariMasingMasing==day) {
                            var elem = $('#kolom'+i);                          
                            if(!elem.hasClass('warnainTH')){
                            elem.addClass('warnainTH');
                            }
                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(!elem1.hasClass('warnainShift')){
                                elem1.addClass('warnainShift');
                                }
                            }

                        } else{

                            var elem = $('#kolom'+i);                          
                            if(elem.hasClass('warnainTH')){
                            elem.removeClass('warnainTH');
                            }


                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(elem1.hasClass('warnainShift')){
                                elem1.removeClass('warnainShift');
                                }
                                console.log('#kolom'+i+'shift'+e);
                            }
                        }
                    }

                    
                });
            }

            function decreaseValue()
            {
                document.getElementById("div2").innerHTML = ""; 
                var nambah = parseInt(document.getElementById('number').value);
                nambah = isNaN(nambah) ? 0 : nambah;
                nambah-=7;
                document.getElementById('number').value = nambah;
                buatMinggu(nambah);
                
                $(document).ready(function(){
                    var xhttp;
                    xhttp = new XMLHttpRequest(); 
                    xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(this.responseText, "text/html");
                        var elem = doc.getElementById("div1");
                    $("#div2").append(elem.innerHTML);
                    }
                }
                    xhttp.open("GET", "getTampil.php?q="+$("#getHari1").attr("value") + "/" + $("#getHari6").attr("value"), true);
                    xhttp.send();



                    var table= document.getElementById("fetchTabel");
           
                    for(var i = 1; i < table.rows[0].cells.length-1; i ++) {    
                        console.log(i)     
                        var day = moment().format("YYYY-MM-DD")
                        var getHariMasingMasing = document.getElementById("getHari"+(i)).getAttribute("value")
                        
                        console.log(getHariMasingMasing)
                        console.log(day)
                        if (getHariMasingMasing==day) {
                            var elem = $('#kolom'+i);                          
                            if(!elem.hasClass('warnainTH')){
                            elem.addClass('warnainTH');
                            }
                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(!elem1.hasClass('warnainShift')){
                                elem1.addClass('warnainShift');
                                }
                            }

                        } else{

                            var elem = $('#kolom'+i);                          
                            if(elem.hasClass('warnainTH')){
                            elem.removeClass('warnainTH');
                            }


                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(elem1.hasClass('warnainShift')){
                                elem1.removeClass('warnainShift');
                                }
                                console.log('#kolom'+i+'shift'+e);
                            }
                        }
                    }

                    
                });
            }
            
                $(document).ready(function(){
                    
                    var xhttp;
                    xhttp = new XMLHttpRequest(); 
                    xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(this.responseText, "text/html");
                        var elem = doc.getElementById("div1");
                    $("#div2").append(elem.innerHTML);
                    }
                }
                    xhttp.open("GET", "getTampil.php?q="+$("#getHari1").attr("value") + "/" + $("#getHari6").attr("value"), true);
                    xhttp.send();
                

                    var table= document.getElementById("fetchTabel");
           
                    for(var i = 1; i < table.rows[0].cells.length-1; i ++) {    
                        console.log(i)     
                        var day = moment().format("YYYY-MM-DD")
                        var getHariMasingMasing = document.getElementById("getHari"+(i)).getAttribute("value")
                        
                        console.log(getHariMasingMasing)
                        console.log(day)
                        if (getHariMasingMasing==day) {
                            var elem = $('#kolom'+i);                          
                            if(!elem.hasClass('warnainTH')){
                            elem.addClass('warnainTH');
                            }
                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(!elem1.hasClass('warnainShift')){
                                elem1.addClass('warnainShift');
                                }
                            }

                        } else{

                            var elem = $('#kolom'+i);                          
                            if(elem.hasClass('warnainTH')){
                            elem.removeClass('warnainTH');
                            }


                            for (let e = 1; e < 4; e++) {
                                var elem1 = $('#kolom'+i+'shift'+e);                       
                                if(elem1.hasClass('warnainShift')){
                                elem1.removeClass('warnainShift');
                                }
                                console.log('#kolom'+i+'shift'+e);
                            }
                        }
                    }

                });
