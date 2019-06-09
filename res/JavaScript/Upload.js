let poze=document.getElementById("fisiere");
let inf=document.getElementById("completare");
let zona_imagini=document.getElementById("imagine");

let info="";
let reader=new FileReader();
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
        
        if(a.value=='' || b.value=='' || c.value=='')
        {
            incarca.disabled=true;
        }
    else
        {
            incarca.disabled=false;
        }
    }
}
function informatii()
{
    let informati="";
    let img_path='';

       console.log(poze.files.length);
       let i;
       for(i=1;i<=poze.files.length;i++)
       {
        let va=URL.createObjectURL(poze.files[i-1]);
        console.log(va);

            informati=informati+"\n<p>Poza"+i+"</p>\n"+'<label for="tag'+i+'" >Tag'+i+'</label>\n<input type="text" name="Tag'+i+'" id="tag'+i+'">\n'+'<label for="titlu'+i+'">Titlu'+i+'</label>\n<input type="text" name="Titlu'+i+'" id="titlu'+i+'" maxlength="10" placeholder="titlu'+i+'">\n'+'<label for="Descriere'+i+'">Descriere'+i+'</label>\n<textarea rows="4" cols="50" id="Desc'+i+'" name="Descriere'+i+'" maxlength="400"></textarea>\n';
            img_path=img_path+'\n<img src="'+va+'" class="imagine_pusa"alt="o imagine">';
        }
        console.log(img_path);
        zona_imagini.innerHTML=img_path;
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


