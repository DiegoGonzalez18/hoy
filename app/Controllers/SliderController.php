<?php
 


namespace App\Controllers;
use App\Models\{Slider};
class SliderController{

  public function registerSlider($titulo,$archivo,$nombre_archivo){
    // $slider=Slider::all()->count();

                     
  if(!empty($titulo)&&!empty($nombre_archivo)){
    if(!file_exists('uploads')){
        mkdir('uploads',0777,true);
    
      }
        if(move_uploaded_file($archivo,'app/Controllers/uploads/'.$nombre_archivo)){
            
                $slider = new Slider;
                $slider->titulo = $titulo;
                $slider->url = 'uploads/'.$nombre_archivo;
                $as=Slider::where('url','=',$slider->url)->count();
                if($as>0){
                  echo -1;
                }else{
                $slider->save();

            echo 1;
          }
        }else{
          echo 0;
        }
      
  }

  }
  public function listarSlider(){
   $a= Slider::get();
   $cad="";
foreach($a as $item){
  $a=0;
   if($item["visible"]==1){
$a="<center><span class='badge badge-success'>Visible</span></center>";
   }else{
    $a="<center><span class='badge badge-danger'>No Visible</span></center>";
   }
  $cad .=' <tr id="'.$item["id"].'"><td>'.$item["titulo"].'</td>'.
  ' <td><img width="100px"src="../../app/Controllers/'.$item["url"].'"></td>'.
   '<td>'.$a.'</td>'.
   '<td>'.$item["created_at"].'</td>'.
   '<td>'.$item["updated_at"].
   '</td><td class=""><button type="button" class="btn btn-danger eliminar" id="'.$item["id"].'">Eliminar</button></td><td>
   <button type="button" data-toggle="modal" data-target="#modalNuevo" class="btn btn-info editar" id="'.$item["id"].'">Editar</button></td></tr>';
  
   
}
echo $cad;
  }
 
public function traerDatos($id){
  $a=Slider::where('id', '=', $id)->first();
echo json_encode($a);
}
public function listar (){
  $a=Slider::all();
echo json_encode($a);
}

  public function eliminar($id){
   
    $peli=Slider::where('id', '=', $id)->first();
 
 
// Lo eliminamos de la base de datos
  if($peli->delete() ){
    unlink('app/Controllers/'.$peli->url);
    echo '#'.$id;
  }else{
    echo 0;
  }

  }
  public function editarConImagen($id,$titulo,$archivo,$nombre_archivo){
    
    $slider= Slider::where('id','=',$id)->first();
    $num= Slider::where('id','=',$id)->count();
    ;
    unlink('app/Controllers/'.$slider->url);
    if(!empty($titulo)&&!empty($nombre_archivo)){
      if(!file_exists('uploads')){
          mkdir('uploads',0777,true);
      
        }
          if(move_uploaded_file($archivo,'app/Controllers/uploads/'.$nombre_archivo)){
         
            if($num>=1){

                  $slider->titulo = $titulo;
                 
                  $slider->url = 'uploads/'.$nombre_archivo;
                  $as=Slider::where('url','=',$slider->url)->count();
                  if($as>0){
                    echo -1;
                  }else{
                  $slider->save();
  
              echo 1;
            }
          }else{
            echo 0;
          }
        }
  }
}
public function editaSinImagen($id,$titulo){
    
    $slider= Slider::where('id','=',$id)->first();
  
    ;
    if(!empty($titulo)){
      $slider->titulo=$titulo;
      $slider->save();
      echo 1;
  }else{
    echo 0;
  }

}

public function listarAsignacion(){
  echo json_encode(Slider::all());
}


public function asignar($arreglo){
  
  if(count($_POST['arreglo'])<6&&count(json_decode($_POST['arreglo']) )>0){
    
$r=Slider::all();
foreach($r as $t){
  $t->visible=0;
  $t->save();
}$r2=Slider::where(function ($query) {
  foreach(json_decode($_POST['arreglo']) as $select) {
     $query->orWhere('id', '=', $select);
  }
})->get();
foreach($r2 as $t){
  $t->visible=1;
  $t->save();
} echo 1;
}else{
  echo 0;
}
  
  /*foreach ($data as $valor) {
    $valor = $valor * 2;
 $slider=Slider::where('id',"=",$valor);
 $slider->visibilidad=True;
 
 $r=Slider::where(function ($query) {
  foreach(json_decode($_POST['arreglo']) as $select) {
     $query->orWhere('id', '=', $select);
  }
})->get();
foreach($r as $t){
  $t->visible=1;
  $t->save();
}
$r=Slider::where(function ($query) {
  foreach(json_decode($_POST['arreglo']) as $select) {
     $query->orWhere('id', '!=', $select);
  }
})->get();
foreach($r as $t){
  $t->visible=0;
  $t->save();
}
*/

}
public function listarS(){
  $a= Slider::get();
  $cad="";
foreach($a as $item){
  
  if($item['visible']==1){
    $url= 'app/Controllers/'.$item['url'];
    $cad.='<li width="1950px" height="750px"><a href"'.
   $url.'"><img   src ="'.
    $url.'" ><span style="font-family: inherit; font-weight: bold;">'.
    $item['titulo'].' </span></a> </li>';
  }
}
echo $cad;
 }


}

