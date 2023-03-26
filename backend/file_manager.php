<?php
    function create($post) {
        if (trim($post['cpf']) != null && trim($post['nome']) != null && trim($post['tel']) != null && trim($post['ender']) != null) {
            return cadastrarArquivo(dataArray($post), "pessoas");
        }

        echo "<div class='alert alert-danger' role='alert'>";
            echo "Preencha todos os campos!";
        echo "</div>";

        return false;
    }

    function update($post) {
        $data = read();

        $fp = fopen('../database/aux.txt', 'a+');
        if ($fp) {
            fclose($fp);
        }

        foreach($data as $chave => $dados){
            
            if (trim($chave) !== $post['cpf']) {
                $pessoa = array(
                    "cpf" => trim($chave),
                    "nome" => $dados[0],
                    "ender" => $dados[1],
                    "tel" => trim($dados[2])
                );

                cadastrarArquivo(dataArray($pessoa), "aux");
            }else{
                cadastrarArquivo(dataArray($post), "aux");
            }
        }

        unlink('../database/pessoas.txt');
        rename("../database/aux.txt", "../database/pessoas.txt");
        return true;
    }

    function getDadosPessoa($requere) {
        $arr = read();
        foreach($arr as $chave => $dados){
            if (trim($chave)===$requere) {
                $pessoa = array(
                    "cpf" => trim($chave),
                    "nome" => $dados[0],
                    "endereco" => $dados[1],
                    "telefone" => $dados[2]
                );
                return $pessoa;
            }
        }

        $pessoa = array(
            "cpf" => "",
            "nome" => "",
            "endereco" => "",
            "telefone" => ""
        );
        return $pessoa;
    }

    function read() {

        $pessoas = array();
        $fp = fopen('../database/pessoas.txt', 'r');

        if ($fp) {

            while(!feof($fp)) {
                $arr = array();
                $cpf = fgets($fp);
                $dados = fgets($fp);
                if(!empty($dados)) {
                    $arr = explode("#", $dados);
                    $pessoas[$cpf] = $arr;
                }
            }

            fclose($fp);
            return $pessoas;
        }

    }

    function cadastrarArquivo($arr, $arq) {

        $url = "../database/$arq.txt";

		$fp = fopen($url, 'a+');

		if ($fp) {
			foreach($arr as $cpf => $dados) {
				if(!empty($dados)) {
					$linha = $dados['nome']."#".$dados['endereco']."#".$dados['telefone'];
                    fputs($fp, "$cpf\n");
					fputs($fp, "$linha\n");
				}
			}
			fclose($fp);
		}

		return true;
	}

    function dataArray($post) {

		$dados = array(
			$post['cpf'] => array(
				"nome" => $post['nome'],
                "endereco" => $post['ender'],
				"telefone" => $post['tel']
			)
		);

        return $dados;
	}

    function remove($requere){
        $data = read(); 

        $fp = fopen('../database/aux.txt', 'a+');
        if ($fp) {
            fclose($fp);
        }

        foreach($data as $chave => $dados){
            $pessoa = array(
                "cpf" => trim($chave),
                "nome" => $dados[0],
                "ender" => $dados[1],
                "tel" => trim($dados[2])
            );

            if (trim($chave) !== $requere) {
                cadastrarArquivo(dataArray($pessoa), "aux");
            }
        }

        unlink('../database/pessoas.txt');
        rename("../database/aux.txt", "../database/pessoas.txt");
        return true;
    }
    
?>