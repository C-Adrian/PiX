let poze=document.getElementById("fisiere");
let inf=document.getElementById("completare");
let info="";
poze.addEventListener("input",informatii);
let incarca="";
function permitere()
{
    let bu=document.getElementById("Incarca");
    
    let i=0;
    for(i=1;i<=poze.files.length;i++)
    {
        let a = document.getElementById('tag'+i+'');
        let b = document.getElementById('titlu'+i+'');
        let c = document.getElementById('Desc'+i+'');
        console.log(a.value,b.value,c.value);
        if(a.value=='' || b.value=='' || c.value=='')
        {
            console.log("NU");
            incarca.disabled=true;
        }
    else
        {
            console.log("DA");
            incarca.disabled=false;
        }
    }
}
function informatii()
{
    let informati="";

       console.log(poze.files.length);
       let i;
       for(i=1;i<=poze.files.length;i++)
       {
           informati=informati+"\n<p>Poza"+i+"</p>\n"+'<label for="tag'+i+'" >Tag'+i+'</label>\n<input type="text" name="Tag'+i+'" id="tag'+i+'">\n'+'<label for="titlu'+i+'">Titlu'+i+'</label>\n<input type="text" name="Titlu'+i+'" id="titlu'+i+'" maxlength="10" placeholder="titlu'+i+'">\n'+'<label for="Descriere'+i+'">Descriere'+i+'</label>\n<textarea rows="4" cols="50" id="Desc'+i+'" name="Descriere'+i+'" maxlength="400"></textarea>\n';
            
        }
        inf.innerHTML=informati+'<label for="Incarca">Incarca</label><button name="submit" value="Incarca" type="submit" id="Incarca"> Incarca </button>';
        incarca=document.getElementById("Incarca");
        incarca.disabled=true;
        for(i=1;i<=poze.files.length;i++)
        {
            let a= document.getElementById('tag'+i+'');
            let b = document.getElementById('titlu'+i+'');
            let c = document.getElementById('Desc'+i+'');
            a.addEventListener("change",permitere);
            b.addEventListener("change",permitere);
            c.addEventListener("change",permitere);
            //$('input[id="tag'+i+'"]').on('keyup',permitere());
        }
}


