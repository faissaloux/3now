<?php

namespace App\Http\Controllers;


class StatiquePagesController extends Controller
{


  /*

  public function setEnvironmentValue($envKey, $envValue)
  {
      $envFile = app()->environmentFilePath();
      $str = file_get_contents($envFile);

      $oldValue = strtok($str, "{$envKey}=");

      $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

      $fp = fopen($envFile, 'w');
      fwrite($fp, $str);
      fclose($fp);
     

  }
*/

    public function enableDebug(){
     // $this->setEnvironmentValue('APP_DEBUG', 'true');
      // \Artisan::call("config:cache");
    }



    public function disableDebug(){
       //$this->setEnvironmentValue('APP_DEBUG', 'false');
       // \Artisan::call("config:cache");
      }





    public function home(){
       return view('index');
	}


    public function about(){
       return view('about-us');
	}

    public function impressum(){
       return view('impressum');
	}

    public function howitworks(){
       return view('howitworks');
	}

    public function privacypolicy(){
       return view('privacypolicy');
	}

 	public function agb(){
       return view('agb');
	}

 	public function termsandconditions(){
       return view('termsandconditions');
	}

 	public function datenschutz(){
       return view('datenschutz');
	}

 	public function clear(){
        \Artisan::call('cache:clear');
    	return "Cache is cleared";
	}


  public function info(){
    return phpinfo();
  }


    
function get_server_memory_usage(){
  
  $free = shell_exec('free');
  $free = (string)trim($free);
  $free_arr = explode("\n", $free);
  $mem = explode(" ", $free_arr[1]);
  $mem = array_filter($mem);
  $mem = array_merge($mem);
  $memory_usage = $mem[2]/$mem[1]*100;


  return number_format((float)$memory_usage, 2, '.', '');
}

function get_server_cpu_usage(){

  $load = sys_getloadavg();
  return $load[0];

}

  public function usage(){
  



  ?>
<p><span class="description">Server Memory Usage:</span> <span
        class="result"><?php echo  $this->get_server_memory_usage(); ?>%</span></p>
<p><span class="description">Server CPU Usage: </span> <span
        class="result"><?php echo  $this->get_server_cpu_usage(); ?> %</span></p>
<?php
  }




}