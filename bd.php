<?php
    session_start();
    
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=gomesgalvaofacilities", 'root', '');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $dados_brutos = file_get_contents("php://input");

        $dados = json_decode($dados_brutos, true);

        if (($dados !== null) && (($_SESSION['user'] == 'user' && $_SESSION['senha'] == '123456'))) {
            header('Content-Type: application/json');

            $upload_dir = 'assets'. DIRECTORY_SEPARATOR .'imgs'. DIRECTORY_SEPARATOR .'svs';

            if (isset($dados['slide'])) {
                $slide = $dados['slide'];
                $id = $slide['id'];

                $sql = $pdo->prepare("SELECT * FROM slide WHERE id = ?");
                $sql->execute(array($id));
                $result = $sql->fetchAll();

                if (count($result) > 0) {
                    $row = $result[0];

                    if (isset($slide['apagar']) && $slide['apagar']) {
                        if ($row['img'] != 'noneimg.png') {
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }
                        $sql = $pdo->prepare("DELETE FROM slide WHERE id = ?");
                        $sql->execute(array($id));
                    } else {
                        unset($slide['apagar']);
                        if(isset($slide['img'])){
                            $img_name = $slide['imgname'];
                        }else{
                            $img_name = 'noneimg.png';
                        }
                        

                        if (isset($slide['img']) && $slide['img']){
                            $img_base64 = $slide['img'];
                            $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                            if (!file_exists($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }

                            $original_filename = $slide['imgname'];
                            if (strlen($original_filename) > 45) {
                                $extension = strrchr($original_filename, '.');
                                $original_filename = strlen($original_filename) > 45 ? substr($original_filename, 0, 45 - strlen($extension) - 1) : $original_filename;
                                $original_filename = $original_filename . $extension;
                            }

                            $filename = $original_filename;
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            if (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                                while (file_exists($caminhoImagemSalva)) {
                                    $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                    $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                                }
                            }


                            if (file_put_contents($caminhoImagemSalva, $img_data)) {
                                $img_name = $filename;
                            } else {
                                echo json_encode(['error' => 'Erro ao salvar o arquivo.1']);
                            }
                        }
                        if($row['img'] != $img_name && $row['img'] != 'noneimg.png' && isset($slide['imgname']) && isset($slide['img']) && $slide['img']){
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }
                        if (
                            $row['titulo'] != $slide['titulo'] ||
                            $row['minitexto'] != $slide['minitexto'] ||
                            $row['texto'] != $slide['texto'] ||
                            $row['img'] != $img_name
                        ) {
                            $sql = $pdo->prepare("UPDATE slide SET img = ?, titulo = ?, minitexto = ?, texto = ? WHERE id = ?");
                            $sql->execute(array($img_name, $slide['titulo'], $slide['minitexto'], $slide['texto'], $id));
                        }
                    }
                } else {
                    $img_name = 'noneimg.png';
                    if (isset($slide['img'])) {
                        $img_base64 = $slide['img'];
                        $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }

                        $original_filename = $slide['imgname'];
                        if (strlen($original_filename) > 45) {
                            $original_filename = substr($original_filename, 0, 45);
                        }

                        $filename = $original_filename;
                        $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                        if (file_exists($caminhoImagemSalva)) {
                            $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            while (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                            }
                        }


                        if (file_put_contents($caminhoImagemSalva, $img_data)) {
                            $img_name = $filename;
                        } else {
                            echo json_encode(['error' => 'Erro ao salvar o arquivo.2']);
                        }
                    }
                    $sql = $pdo->prepare("INSERT INTO slide (id, img, titulo, minitexto, texto) VALUES (?, ?, ?, ?, ?)");
                    $sql->execute(array($id, $img_name, $slide['titulo'], $slide['minitexto'], $slide['texto']));
                }
            }


            if (isset($dados['secao'])) {
                $secao = $dados['secao'];
                $id = $secao['id'];

                $sql = $pdo->prepare("SELECT * FROM secao WHERE id = ?");
                $sql->execute(array($id));
                $result = $sql->fetchAll();

                if (count($result) > 0) {
                    $row = $result[0];

                    if (isset($secao['apagar']) && $secao['apagar']) {
                        if ($row['img'] != 'noneimg.png') {
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }


                        $sql = $pdo->prepare("SELECT * FROM conjunto WHERE idsecao = ?");
                        $sql->execute(array($id));
                        $result = $sql->fetchAll();
                        foreach($result as $r){
                            if ($r['img'] != 'noneimg.png') {
                                $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $r['img'];
                                if (file_exists($caminhoImagemExcluir)) {
                                    unlink($caminhoImagemExcluir);
                                }
                            }
                            $sql = $pdo->prepare("DELETE FROM conjunto WHERE idsecao = ?");
                            $sql->execute(array($id));
                        }
                        $sql = $pdo->prepare("DELETE FROM secao WHERE id = ?");
                        $sql->execute(array($id));
                    } else {
                        unset($secao['apagar']);
                        if(isset($secao['img'])){
                            $img_name = $secao['imgname'];
                        }else{
                            $img_name = 'noneimg.png';
                        }

                        if (isset($secao['img']) && $secao['img']){
                            $img_base64 = $secao['img'];
                            $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                            if (!file_exists($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }

                            $original_filename = $secao['imgname'];
                            if (strlen($original_filename) > 45) {
                                $extension = strrchr($original_filename, '.');
                                $original_filename = strlen($original_filename) > 45 ? substr($original_filename, 0, 45 - strlen($extension) - 1) : $original_filename;
                                $original_filename = $original_filename . $extension;
                            }

                            $filename = $original_filename;
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            if (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                                while (file_exists($caminhoImagemSalva)) {
                                    $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                    $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                                }
                            }


                            if (file_put_contents($caminhoImagemSalva, $img_data)) {
                                $img_name = $filename;
                            } else {
                                echo json_encode(['error' => 'Erro ao salvar o arquivo.1']);
                            }
                        }
                        if($row['img'] != $img_name && $row['img'] != 'noneimg.png' && isset($secao['imgname']) && isset($secao['img']) && $secao['img']){
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }
                        if (
                            $row['titulo'] != $secao['titulo'] ||
                            $row['img'] != $img_name
                        ) {
                            $sql = $pdo->prepare("UPDATE secao SET img = ?, titulo = ? WHERE id = ?");
                            $sql->execute(array($img_name, $secao['titulo'], $id));
                        }
                    }
                } else {
                    $img_name = 'noneimg.png';
                    if (isset($secao['img'])) {
                        $img_base64 = $secao['img'];
                        $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }

                        $original_filename = $secao['imgname'];
                        if (strlen($original_filename) > 45) {
                            $original_filename = substr($original_filename, 0, 45);
                        }

                        $filename = $original_filename;
                        $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                        if (file_exists($caminhoImagemSalva)) {
                            $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            while (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                            }
                        }


                        if (file_put_contents($caminhoImagemSalva, $img_data)) {
                            $img_name = $filename;
                        } else {
                            echo json_encode(['error' => 'Erro ao salvar o arquivo.2']);
                        }
                    }
                    $sql = $pdo->prepare("INSERT INTO secao (id, img, titulo) VALUES (?, ?, ?)");
                    $sql->execute(array($id, $img_name, $secao['titulo']));
                }
            }

            if (isset($dados['conjunto'])) {
                $conjunto = $dados['conjunto'];
                $id = $conjunto['id'];

                $sql = $pdo->prepare("SELECT * FROM conjunto WHERE id = ?");
                $sql->execute(array($id));
                $result = $sql->fetchAll();

                if (count($result) > 0) {
                    $row = $result[0];

                    if (isset($conjunto['apagar']) && $conjunto['apagar']) {
                        if ($row['img'] != 'noneimg.png') {
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }
                        $sql = $pdo->prepare("DELETE FROM conjunto WHERE id = ?");
                        $sql->execute(array($id));
                    } else {
                        unset($conjunto['apagar']);
                        if(isset($conjunto['img']) && isset($conjunto['imgname'])){
                            $img_name = $conjunto['imgname'];
                        }else{
                            $img_name = 'noneimg.png';
                        }

                        if (isset($conjunto['img']) && $conjunto['img']){
                            $img_base64 = $conjunto['img'];
                            $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                            if (!file_exists($upload_dir)) {
                                mkdir($upload_dir, 0777, true);
                            }

                            $original_filename = $conjunto['imgname'];
                            if (strlen($original_filename) > 45) {
                                $extension = strrchr($original_filename, '.');
                                $original_filename = strlen($original_filename) > 45 ? substr($original_filename, 0, 45 - strlen($extension) - 1) : $original_filename;
                                $original_filename = $original_filename . $extension;
                            }

                            $filename = $original_filename;
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            if (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                                while (file_exists($caminhoImagemSalva)) {
                                    $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                    $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                                }
                            }


                            if (file_put_contents($caminhoImagemSalva, $img_data)) {
                                $img_name = $filename;
                            } else {
                                echo json_encode(['error' => 'Erro ao salvar o arquivo.1']);
                            }
                        }
                        if($row['img'] != $img_name && $row['img'] != 'noneimg.png' && isset($conjunto['imgname']) && isset($conjunto['img']) && $conjunto['img']){
                            $caminhoImagemExcluir = $upload_dir . DIRECTORY_SEPARATOR . $row['img'];
                            if (file_exists($caminhoImagemExcluir)) {
                                unlink($caminhoImagemExcluir);
                            }
                        }
                        if (
                            $row['texto'] != $conjunto['texto'] ||
                            $row['idsecao'] != $conjunto['idsecao'] ||
                            $row['img'] != $img_name
                        ) {
                            $sql = $pdo->prepare("UPDATE conjunto SET img = ?, texto = ?, idsecao = ? WHERE id = ?");
                            $sql->execute(array($img_name, $conjunto['texto'], $conjunto['idsecao'], $id));
                        }
                    }
                } else {
                    $img_name = 'noneimg.png';
                    if (isset($conjunto['img'])) {
                        $img_base64 = $conjunto['img'];
                        $img_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img_base64));

                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }

                        $original_filename = $conjunto['imgname'];
                        if (strlen($original_filename) > 45) {
                            $original_filename = substr($original_filename, 0, 45);
                        }

                        $filename = $original_filename;
                        $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                        if (file_exists($caminhoImagemSalva)) {
                            $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                            $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;

                            while (file_exists($caminhoImagemSalva)) {
                                $filename = substr(uniqid(), 0, 10) . '_' . substr($original_filename, 0, 30);
                                $caminhoImagemSalva = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                            }
                        }


                        if (file_put_contents($caminhoImagemSalva, $img_data)) {
                            $img_name = $filename;
                        } else {
                            echo json_encode(['error' => 'Erro ao salvar o arquivo.2']);
                        }
                    }
                    $sql = $pdo->prepare("INSERT INTO conjunto (id, img, texto, idsecao) VALUES (?, ?, ?, ?)");
                    $sql->execute(array($id, $img_name, $conjunto['texto'], $conjunto['idsecao']));
                }
            }



        } else {

            http_response_code(400);
            echo json_encode(['error' => 'Erro ao processar os dados.']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    
        $data = array('slides'=>array(), 'secoes'=>array());
    
        $sql = $pdo->prepare("SELECT * FROM slide");
        $sql->execute();
        $data['slides'] = $sql->fetchAll();
    
        $sql = $pdo->prepare("SELECT * FROM secao");
        $sql->execute();
        $secoes = $sql->fetchAll();
    
        foreach($secoes as $sec){
            $sql = $pdo->prepare("SELECT * FROM conjunto WHERE idsecao = ?");
            $sql->execute([$sec['id']]);
            $conjuntos = $sql->fetchAll();
    
            $sec['conjuntos'] = $conjuntos;
    
            $data['secoes'][] = $sec;
        }
    
        echo json_encode($data);
    }
    
    else{
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido.']);    
    }

    $pdo = null;
?>