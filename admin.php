<?php

    if(isset($_POST['user'])){
        if($_POST['user'] != 'user' || $_POST['senha'] != '123456'){
            header("location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
        }
        session_start();
        $_SESSION["user"]=$_POST['user'];
        $_SESSION["senha"]=$_POST['senha'];
    } else{
        header("location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
    }

    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=gomesgalvaofacilities", 'root', '');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Admin</title>
    <style>
        .some{
            display: none;
        }
        html{
            font-weight: 500;
            font-size: 1px;
            font-family: 'Maven Pro', sans-serif;
        }

        .column img{
            max-width: 100px;
            max-height: 100px;
        }

        *:not(button){
            margin: 0;
            padding: 0;
            border: 0;
            transition: all 0.5s;
        }

        button{
            transition: all 0.5s;
        }

        body{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            font-size: 12rem;
            color: #34495E;
            overflow-x: hidden;
            padding-bottom: 50rem;
        }

        .entidades{
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .entidade{
            width: 201px;
            margin-top: 20rem;
            padding: 0 34px 34px 34px;
            border-radius: 19px;
            border: 1px solid rgba(255, 0, 0, 0.08);
            background: #FFF;
            box-shadow: 0px 4px 20px 0px rgba(255, 0, 0, 0.54), 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .padrao{
            display: none;
        }


        .slide{
            min-height: 384px;
        }
        h1{
            width: 202px;
            height: 36px;
            font-size: 23rem;
            font-weight: 700;
            color: #C72F31;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        label{
            width: 202px;
            height: 22px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row;
        }

        label.column{
            width: 202px;
            height: 117px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        input{
            width: 138px;
            height: 22px;
            background-color: transparent;
            border: 1px solid;
            border-radius: 7px;
        }
        label.column textarea{
            min-height: 95rem;
            margin-top: 5rem;
        }

        textarea{
            transition: box-shadow 0.5s;
            border-radius: 7px;
            border: 1px solid #000;
            background: #FFF;
            background-color: inherit;
        }

        .plus{
            width: 206rem;
            height: 38rem;
            margin-top: 20rem;
            border-radius: 7px;
            border: 1px solid #00000024;
            background-color: #fff;
            background-image: url('assets/imgs/add.svg');
            background-repeat: no-repeat;
            background-size: 24rem;
            background-position: center;
        }

        .plus:hover, textarea:hover, input:hover{
            box-shadow: 0px 4px 20px 0px rgba(255, 0, 0, 0.54);
        }

        .salvar{
            width: 206rem;
            height: 38rem;
            margin-top: 20rem;
            border-radius: 7px;
            border: 1px solid #00000024;
            background-color: #fff;
            font-weight: 900;
            font-size: 16px;
            color: #0ED121;
        }

        .salvar:hover{
            font-size: 20px;
            box-shadow: 0px 4px 20px 0px rgba(0, 255, 43, 0.54);
        }

        .remover{
            width: 22rem;
            height: 22rem;
            margin-top: 8px;
            margin-left: 210rem;
            border-radius: 100%;
            position: absolute;
            background-image: url('assets/imgs/remove.svg');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }

        .remover:hover{
            transform: scale(1.1);
        }

        .delete .remover{
            background-image: url('assets/imgs/addverde.svg');
        }

        .delete{
            background-color: #f9d5d5!important;
        }

        .conjunto{
            margin-top: 30px;
            border-radius: 18rem;
            width: 237rem;
            min-height: 198rem;
            background-color: #0181ff29;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-bottom: 30rem;
            border: 1px solid rgba(196, 9, 11, 0.3);
        }

        .conjunto.padrao{
            display: none;
        }

        .conjunto .remover{
            margin-left: 198px;
            margin-bottom: 202px;
            margin-top: 0;
        }

        .preencha, .preencha+.upload{
            background-color: red;
            box-shadow: 0px 0px 20px 50px rgb(0 255 7 / 54%), 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }


    </style>
</head>
<body>
    <div class="slides entidades">
        <div class="slide entidade padrao">
            <button class="remover" onclick="remover(this)"></button>
            <h1>Slide #-++++-</h1>
            <label for="imgslide" class="column">Fundo: <input type="file" class="img some" name="imgslide" accept="image/*"><button class="upload" onclick="upload(this)"><h5>Upload</h5><img src="" alt=""></button></label>
            <label for="tituloslide">Título:<input placeholder="Limite: 50 caracteres" maxlength="50" type="text" name="tituloslide" class="tituloslide" accept="image/*"></label>
            <label for="pequenadesc" class="column">Pequena descrição: <textarea placeholder="Limite: 63 caracteres" maxlength="63" type="text" name="pequenadesc" class="pequenadesc"></textarea> </label>
            <label for="grandedesc" class="column">Grande descrição: <textarea placeholder="Limite: 235 caracteres" maxlength="235" type="text" name="grandedesc" class="grandedesc"></textarea></label>
        </div>
        <button class="plus" onclick="duplicar(this)"></button>
    </div>

    <div class="secoes entidades">
        <div class="secao entidade padrao">
            <button class="remover" onclick="remover(this)"></button>
            <h1>Seção #-++++-</h1>
            <label for="imgsecao" class="column">Fundo: <input type="file" class="img some" name="imgsecao" accept="image/*"><button class="upload" onclick="upload(this)"><h5>Upload</h5><img src="" alt=""></button></label>
            <label for="titulosecao">Título:<input placeholder="Limite: 50 caracteres" maxlength="50" type="text" name="titulosecao" class="titulosecao" accept="image/*"></label>
            
            <div class="conjunto padrao">
                <h1 class="some">conjunto #-++++-</h1>
                <button class="remover" onclick="remover(this)"></button>
                <label for="imgconjunto" class="column">Imagem: <input type="file" class="img some" name="imgconjunto" accept="image/*"><button class="upload" onclick="upload(this)"><h5>Upload</h5><img src="" alt=""></button></label>
                <label for="texto" class="column">Texto: <textarea placeholder="Limite: 311 caracteres" maxlength="311" type="text" name="texto" class="texto"></textarea> </label>
            </div>
            <button class="plus" onclick="duplicar(this)"></button> 
        </div>
        <button class="plus" onclick="duplicar(this)"></button>
    </div>
    <button class="salvar" onclick="verificarantes()">Salvar</button>
    <script>

        function lerImagem(input) {
            return new Promise((resolve) => {
                if (input.files.length > 0) {
                    var reader = new FileReader();

                    reader.onload = function (event) {
                        resolve(event.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    resolve(null);
                }
            });
        }
        function getFileName(input) {
            if (input.files && input.files.length > 0) {
                const file = input.files[0];
                return file.name;
            } else {
                return null;
            }
        }

        function verificarantes(){
            liberado = true;
            document.querySelectorAll('input:not([type="file"]):not(.padrao *), textarea:not(.padrao *)').forEach((e) => {
                if(e.className.includes('preencha')){
                    e.classList.remove('preencha');
                }
                if(e.value == ''){
                    e.classList.add('preencha');
                    liberado = false;
                }
            })
            document.querySelectorAll('input[type="file"]:not(.padrao *)').forEach((e) => {
                if(e.className.includes('preencha')){
                    e.classList.remove('preencha');
                }
                if(e.nextSibling.querySelector('h5').innerHTML == 'Upload' || e.nextSibling.querySelector('h5').innerHTML == 'noneimg.png'){
                    e.classList.add('preencha');
                    liberado = false;
                }
            })
            if(liberado){
                salvar();
            }
        }


        function salvar() {
            slides = [];

            promises = [];
            document.querySelectorAll('.slide:not(.padrao)').forEach((e) => {
                imginput = e.querySelector('input[name="imgslide"]');

                if(imginput.value != ''){
                    promises.push(
                        lerImagem(imginput).then((img) => {
                            slides.push({
                                id: e.querySelector('h1').innerHTML.split('#')[1],
                                img: img,
                                imgname: e.querySelector('button h5').innerHTML.split('/')[1],
                                titulo: e.querySelector('input[name="tituloslide"]').value,
                                minitexto: e.querySelector('textarea[name="pequenadesc"]').value,
                                texto: e.querySelector('textarea[name="grandedesc"]').value,
                                apagar: e.classList.contains('delete') ? true : false
                            });
                        })
                    );
                }else{
                    slides.push({
                        id: e.querySelector('h1').innerHTML.split('#')[1],
                        img: false,
                        imgname: e.querySelector('button h5').innerHTML.split('/')[1],
                        titulo: e.querySelector('input[name="tituloslide"]').value,
                        minitexto: e.querySelector('textarea[name="pequenadesc"]').value,
                        texto: e.querySelector('textarea[name="grandedesc"]').value,
                        apagar: e.classList.contains('delete') ? true : false
                    });
                }
            });
            secoes = []
            conjuntos = []
            document.querySelectorAll('.secao:not(.padrao)').forEach((e)=>{

                if(!e.classList.contains('delete')){
                    e.querySelectorAll('.conjunto:not(.padrao .conjunto):not(.padrao.conjunto)').forEach(i=>{
                        imgcon = i.querySelector('input[name="imgconjunto"]');
                        if(imgcon.value != ''){
                            promises.push(
                                lerImagem(imgcon).then((img) => {
                                    conjuntos.push({
                                        id: i.querySelector('h1').innerHTML.split('#')[1],
                                        idsecao: i.parentNode.querySelector('h1').innerHTML.split('#')[1],
                                        img: img,
                                        imgname: i.querySelector('button h5').innerHTML.split('/')[1],
                                        texto: i.querySelector('textarea[name="texto"]').value,
                                        apagar: i.classList.contains('delete') ? true : false
                                    });
                                })
                            );
                        } else{
                            conjuntos.push({
                                id: i.querySelector('h1').innerHTML.split('#')[1],
                                idsecao: i.parentNode.querySelector('h1').innerHTML.split('#')[1],
                                img: false,
                                imgname: i.querySelector('button h5').innerHTML.split('/')[1],
                                texto: i.querySelector('textarea[name="texto"]').value,
                                apagar: i.classList.contains('delete') ? true : false
                            });
                        }
                    })
                }
                imgsec = e.querySelector('input[name="imgsecao"]');
                if(imgsec.value != ''){
                    promises.push(
                        lerImagem(imgsec).then((img) => {
                            secoes.push({
                                id: e.querySelector('h1').innerHTML.split('#')[1],
                                img: img,
                                imgname: e.querySelector('button h5').innerHTML.split('/')[1],
                                titulo: e.querySelector('input[name="titulosecao"]').value,
                                apagar: e.classList.contains('delete') ? true : false
                            });
                        })
                    );
                }else{
                    secoes.push({
                        id: e.querySelector('h1').innerHTML.split('#')[1],
                        img: false,
                        imgname: e.querySelector('button h5').innerHTML.split('/')[1],
                        titulo: e.querySelector('input[name="titulosecao"]').value,
                        apagar: e.classList.contains('delete') ? true : false
                    });
                }
            })

            Promise.all(promises).then(() => {
                slides.forEach((i) => {
                    data = { slide: i };
                    console.log(data);
                    fetch('bd.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        return response.text().then(text => {
                            console.error('Resposta não-JSON:', text);
                        });
                    });
                });

                secoes.forEach((i) => {
                    data = { secao: i };
                    console.log(data);
                    fetch('bd.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        return response.text().then(text => {
                            console.error('Resposta não-JSON:', text);
                        });
                    });
                });

                const conjuntoPromises = conjuntos.map(i => {
                    data = { conjunto: i };
                    console.log(data);
                    return fetch('bd.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {
                        return response.text().then(text => {
                            console.error('Resposta não-JSON:', text);
                        });
                    });
                });

                return Promise.all(conjuntoPromises);
            })
            .then(() => {
                console.log('Todos os conjuntos foram processados.');
            })
            .catch(error => {
                console.error('Erro ao processar conjuntos:', error);
            });
        }


        var cont = {'slide': 0, 'secao': 0, 'conjunto': 0}
        function duplicar(btn){
            cont[btn.previousElementSibling.classList[0]]++
            novoE = document.querySelector('.'+btn.previousElementSibling.classList[0]+'.padrao').cloneNode(true);
            novoE.classList.remove('padrao');
            novoE.querySelector('h1').innerHTML = novoE.querySelector('h1').innerHTML.replace('-++++-', cont[btn.previousElementSibling.classList[0]])
            btn.parentNode.insertBefore(novoE, btn);
            novoE.querySelectorAll('.upload').forEach((e)=>{
                e.querySelector('h5').innerHTML = 'Upload';
                e.querySelector('img').src = '';
            })

            novoE.querySelectorAll('.padrao').forEach((e)=>{
                e.classList.remove('padrao')
            })

            if(novoE.querySelectorAll('.conjunto').length > 0){
                var first = true;
                novoE.querySelectorAll('.conjunto').forEach((e)=>{
                    if(first){
                        e.classList.add('padrao')
                        e.classList.add('some')
                        first = false;
                        e.querySelector('h1').innerHTML = e.querySelector('h1').innerHTML.replace('-++++-', cont[btn.previousElementSibling.classList[0]])
                    }else{
                        alert('oi???')
                    }
                })
            }
        }

        function remover(btn){

            if(btn.parentNode.className.includes('delete')){
                btn.parentNode.classList.remove('delete');
            } else{
                btn.parentNode.classList.add('delete');
            }
                
        }

        function upload(btn, auto){
            var file = btn.previousElementSibling;
            var img = btn.querySelector('img'); 
            file.click();
            function onChange() {
                if(file.files && file.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        var url = e.target.result;
                        img.src = url;
                        btn.querySelector('h5').innerHTML = 'Carregado: /' + file.files[0].name + '/';
                    }                    
                    reader.readAsDataURL(file.files[0]);
                } else {
                    btn.querySelector('h5').innerHTML = 'Upload';
                    img.src = '';
                }
                file.removeEventListener('change', onChange);
            }
            file.addEventListener('change', onChange);
        }
        
        function carregarbd(){

            fetch('bd.php', {
                method: 'GET',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao obter os dados do servidor.');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);

                data.slides.forEach((i)=>{
                    cont['slide'] =i.id-1;
                    sec = document.querySelector('.slides');
                    sec.querySelector('.plus').click();
                    
                    slide = sec.querySelector('div:has(+:last-child)');
                    slide.querySelector('h1').innerHTML = slide.querySelector('h1').innerHTML.split('#')[0]+'#'+i.id;
                    slide.querySelector('input[name="tituloslide"]').value = i.titulo;
                    slide.querySelector('textarea[name="pequenadesc"]').value = i.minitexto;
                    slide.querySelector('textarea[name="grandedesc"]').value = i.texto;

                    slide.querySelector('.upload img').src = 'assets/imgs/svs/'+i.img;
                    slide.querySelector('.upload').querySelector('h5').innerHTML = 'Carregado: /' + i.img + '/';
                });

                data.secoes.forEach((i)=>{
                    cont['secao'] = i.id-1;
                    sec = document.querySelector('.secoes');
                    sec.querySelector('.secao + button').click();
                    
                    secao = sec.querySelector('.secao:has(+button)');
                    secao.querySelector('h1').innerHTML = secao.querySelector('h1').innerHTML.split('#')[0]+'#'+i.id;
                    secao.querySelector('input[name="titulosecao"]').value = i.titulo;

                    secao.querySelector('.upload img').src = 'assets/imgs/svs/'+i.img;
                    secao.querySelector('.upload').querySelector('h5').innerHTML = 'Carregado: /' + i.img + '/';

                    i.conjuntos.forEach((j)=>{
                        if(cont['conjunto'] < j.id-1){
                            cont['conjunto'] = j.id-1;
                        }
                        secao.querySelector('.plus').click();
                        
                        conjunto = secao.querySelector('div:has(+:last-child)');
                        conjunto.querySelector('h1').innerHTML = conjunto.querySelector('h1').innerHTML.split('#')[0]+'#'+j.id;
                        conjunto.querySelector('textarea[name="texto"]').value = j.texto;

                        conjunto.querySelector('.upload img').src = 'assets/imgs/svs/'+j.img;
                        conjunto.querySelector('.upload').querySelector('h5').innerHTML = 'Carregado: /' + j.img + '/';

                    })


                });


            })
            .catch(error => {
                console.error('Erro:', error);
            });
        }


       carregarbd()
    </script>
</body>
</html>

<?php $pdo = null; ?>