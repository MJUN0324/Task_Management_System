<!doctype html>
<html lang="en">

<head>
    <title>Answer compare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <style type="text/css">
        ins {color:green;background:#dfd;text-decoration:none}
        del {color:red;background:#fdd;text-decoration:none}
        #params {margin:1em 0;font: 14px sans-serif}
        .panecontainer > p {margin:0;border:1px solid #bcd;border-bottom:none;padding:1px 3px;font:14px sans-serif}
        .panecontainer > p + div {margin:0;padding:2px 0 2px 2px;border:1px solid #bcd;border-top:none}
        .pane {margin:0;padding:0;border:0;width:100%;min-height:20em;overflow:auto;font:12px monospace}
        #htmldiff {color:gray}
        #htmldiff.onlyDeletions ins {display:none}
        #htmldiff.onlyInsertions del {display:none}
    </style>

    <?php
        include_once '../../src/autoload.php';
        require_once '../../src/connection/mysql_conn.php';

        session_start();

        if(empty($_SESSION['info']) || $_SESSION['type'] != "company") {
            echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
            die("Redirecting to login.php");
        }
    ?>


</head>
<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <!-- Font Awesome 5 JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.1/js/all.js"
        integrity="sha384-BtvRZcyfv4r0x/phJt9Y9HhnN5ur1Z+kZbKVgzVBAlQZX4jvAuImlIz+bG7TS00a"
        crossorigin="anonymous"></script>

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <a href="./">
                        <img src="../../assets/img/HKVEPlogo.png" />
                    </a>                        
                </div>
                <div class="col-lg-6 d-flex justify-content-end align-self-center">
                    <div class="dropdown dropdown-menu-right">
                        <button class="btn btn-link dropdown-toggle text-white" type="button" data-toggle="dropdown">
                            <?= unserialize($_SESSION["info"])->get_username(); ?>
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu ">
                            <a href="../../src/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

        <?php
            function stripslashes_deep(&$value) {
	        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	        return $value;
	    }
        if ( (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) || (ini_get('magic_quotes_sybase') && strtolower(ini_get('magic_quotes_sybase'))!="off") ) {
	        stripslashes_deep($_GET);
	        stripslashes_deep($_POST);
	    }

        include '../../vendor/finediff.php';

        $cache_lo_water_mark = 900;
        $cache_hi_water_mark = 1100;
        $compressed_serialized_filename_extension = '.store.gz';

        $granularity = 2;
        $from_text = '';
        $to_text = '';
        $diff_opcodes = '';
        $diff_opcodes_len = 0;
        $data_key = '';

        $start_time = gettimeofday(true);

        // restore from cache
        if ( isset($_GET['data']) ) {
	    if ( ctype_alnum($_GET['data']) ) {
		$filename = "{$_GET['data']}{$compressed_serialized_filename_extension}";
		$compressed_serialized_data = @file_get_contents("./cache/{$filename}");
		if ( $compressed_serialized_data !== false ) {
			@touch("./cache/{$filename}");
			$data_from_serialization = unserialize(gzuncompress($compressed_serialized_data));
			$granularity = $data_from_serialization['granularity'];
			$from_text = $data_from_serialization['from_text'];
			$diff_opcodes = $data_from_serialization['diff_opcodes'];
			$diff_opcodes_len = strlen($diff_opcodes);
			$to_text = FineDiff::renderToTextFromOpcodes($from_text, $diff_opcodes);
			$data_key = $data_from_serialization['data_key'];
			}
		else {
			echo '<p style="font-size:smaller">The page you are looking for has expired.</p>', "\n";
			}
		}
	    $exec_time = gettimeofday(true) - $start_time;
	    }
        // new diff
        else {
	        if ( isset($_POST['granularity']) && ctype_digit($_POST['granularity']) ) {
		        $granularity = max(min(intval($_POST['granularity']),3),0);
		    }
	        if ( !empty($_POST['from']) || !empty($_POST['to'])) {
		        if ( !empty($_POST['from']) ) {
			        $from_text = $_POST['from'];
			    }
		        if ( !empty($_POST['to']) ) {
			        $to_text = $_POST['to'];
			    }
		    }
	    // limit input
	    $from_text = substr($from_text, 0, 1024*100);
	    $to_text = substr($to_text, 0, 1024*100);

	    // ensure input is suitable for diff
	    $from_text = mb_convert_encoding($from_text, 'HTML-ENTITIES', 'UTF-8');
	    $to_text = mb_convert_encoding($to_text, 'HTML-ENTITIES', 'UTF-8');

	    $granularityStacks = array(
		FineDiff::$paragraphGranularity,
		FineDiff::$sentenceGranularity,
		FineDiff::$wordGranularity,
		FineDiff::$characterGranularity
		);
	    $diff_opcodes = FineDiff::getDiffOpcodes($from_text, $to_text, $granularityStacks[$granularity]);
	    $diff_opcodes_len = strlen($diff_opcodes);
	    $exec_time = gettimeofday(true) - $start_time;
	    if ( $diff_opcodes_len ) {
		    $data_key = sha1(serialize(array('granularity' => $granularity, 'from_text' => $from_text, 'diff_opcodes' => $diff_opcodes)));
		    $filename = "{$data_key}{$compressed_serialized_filename_extension}";
		if ( !file_exists("./cache/{$filename}") ) {
			// purge cache if too many files
			if ( !(time() % 100) ) {
				$files = glob("./cache/*{$compressed_serialized_filename_extension}");
				$num_files = $files ? count($files) : 0;
				if ( $num_files > $cache_hi_water_mark ) {
					$sorted_files = array();
					foreach ( $files as $file ) {
						$sorted_files[strval(@filemtime("./cache/{$file}")).$file] = $file;
						}
					ksort($sorted_files);
					foreach ( $sorted_files as $file ) {
						@unlink("./cache/{$file}");
						$num_files -= 1;
						if ( $num_files < $cache_lo_water_mark ) {
							break;
							}
						}
					}
				}
			// save diff in cache
			$data_to_serialize = array(
				'granularity' => $granularity,
				'from_text' => $from_text,
				'diff_opcodes' => $diff_opcodes,
				'data_key' => $data_key,
				);
			$serialized_data = serialize($data_to_serialize);
			@file_put_contents("./cache/{$filename}", gzcompress($serialized_data));
			@chmod("./cache/{$filename}", 0666);
			}
		}
	}

    $rendered_diff = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $diff_opcodes);
    $from_len = strlen($from_text);
    $to_len = strlen($to_text);

    ?>

    <?php
        //new
        if(isset($_GET['id']) && isset($_GET['cand1']) && isset($_GET['cand2'])){
            $taskID = $_GET['id'];
            $cand1 = $_GET['cand1'];
            $cand2 = $_GET['cand2'];
            $controller = new controller\taskController();
            $answer1 = $controller->getAnswer($taskID,$cand1);
            $answer2 = $controller->getAnswer($taskID,$cand2);
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-md-2">

            <form action="plagiarism.php?id=<?= $taskID?>&cand1=<?= $cand1?>&cand2=<?= $cand2?>" method="post">
                <div class="panecontainer" style="display:inline-block;width:49.5%"><p>Original candidate</p>
                    <div>
                        <textarea name="from" class="pane form-control" readonly><?= strip_tags($answer1)?></textarea>
                    </div> 
                </div>
                <div class="panecontainer" style="display:inline-block;width:49.5%"><p>Another candidate</p>
                    <div>
                        <textarea name="to" class="pane form-control" readonly><?= strip_tags($answer2)?></textarea>
                    </div>
                </div>
                <div>
                    <p id="params">Granularity: <input name="granularity" type="radio" value="0"<?php if ( $granularity === 0 ) { echo ' checked="checked"'; } ?>>&thinsp;Paragraph/lines&ensp;<input name="granularity" type="radio" value="1"<?php if ( $granularity === 1 ) { echo ' checked="checked"'; } ?>>&thinsp;Sentence&ensp;<input name="granularity" type="radio" value="2"<?php if ( $granularity === 2 ) { echo ' checked="checked"'; } ?>>&thinsp;Word&ensp;<input name="granularity" type="radio" value="3"<?php if ( $granularity === 3 ) { echo ' checked="checked"'; } ?>>&thinsp;Character&emsp;<input class="btn btn-danger" type="submit" value="View difference">&emsp;<a href="plagiarism.php?id=<?= $rc_cand1['taskID']?>&cand1=<?= $rc_cand1['candidateID']?>&cand2=<?= $rc_cand2['candidateID']?>"></a></p>
                </div>
            </form>
            <div class="panecontainer" style="width:99%"><p>Difference <span style="color:gray">(length: <?php echo $diff_opcodes_len; ?> chars)</span>&emsp;&emsp;Show <input type="radio" name="htmldiffshow" onclick="setHTMLDiffVisibility('deletions');"> Original candidate only&ensp;<input type="radio" name="htmldiffshow" checked="checked" onclick="setHTMLDiffVisibility();"> All&ensp;<input type="radio" name="htmldiffshow" onclick="setHTMLDiffVisibility('insertions');"> Another candidate only</p>
                <div id="htmldiff" class="pane" style="white-space:pre-wrap"><?php echo $rendered_diff; ?>
                </div>
            </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container-fluid">
            <small>
                ©Copyright
                <script>
                    var year = 2020;
                    document.write(year + (new Date().getFullYear() > year && " - " + new Date().getFullYear()));
                </script>
                The Hong Kong Vocational English Programme, All Rights Reserved
            </small>
        </div>
    </footer>

    <script type="text/javascript">

    function setHTMLDiffVisibility(what) {
	    var htmldiffEl = document.getElementById('htmldiff'),
		    className = htmldiffEl.className;
	    className = className.replace(/\bonly(Insertions|Deletions)\b/g, '').replace(/\s{2,}/g, ' ').replace(/\s+$/, '').replace(/^\s+/, '');
	    if ( what === 'deletions' ) {
		    htmldiffEl.className = className + ' onlyDeletions';
		}
	    else if ( what === 'insertions' ) {
		    htmldiffEl.className = className + ' onlyInsertions';
		}
	    else {
		    htmldiffEl.className = className;
		}
	}

</script>
</body>
</html>
