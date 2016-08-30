<?php

class TableController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function index()
	{
		$topik = Topik::all();
		$ret = array();
		$i = 0;
		foreach($topik as $top){
			$ret[$i] = array('id'=>$topik[$i]['kode'],'text'=>$topik[$i]['nama']);
			$i++;
		}

		return View::make('Table.index')->with("topik",json_encode($ret));
	}

	public function getVariable($topik){
		$variable = Topik::find($topik)->topikVariabel;

		$ret = array();
		$i = 0;
		foreach($variable as $var){
			$temp = Variabel::find($variable[$i]['kode_variabel']);
			$ret[$i] = array('id'=>$variable[$i]['kode_variabel'],'text'=>$temp['nama']);
			$i++;
		}
		return Response::json($ret);
	}

	public function getRegional($topik,$variabel){
		$kodeTopikVariabel = TopikVariabel::where('kode_topik','=',$topik)->where('kode_variabel','=',$variabel)->get();

		$fakta = Fakta::where('kode_topik_variabel','=',$kodeTopikVariabel[0]["kode"])->get();
		$kodeWilayah = array();
		$i=0;
		$ret = array
		(
			array("id"=>1,"text"=>"Nasional"),
			array("id"=>2,"text"=>"Provinsi"),
			array("id"=>3,"text"=>"Kabupaten")
		);
		
		$region = array(0,0,0);
		
		foreach($fakta as $fact){
			$ssWilayah = Wilayah::find($fact["kode_wilayah"])["tipe"];
			if($ssWilayah==0) $region[0] = 1;
			if($ssWilayah==1) $region[1] = 1;
			if($ssWilayah==2) $region[2] = 1;

			$kodeWilayah[$i] = $ssWilayah; 
			$i++;
		}

		for($i=0;$i<3;$i++){
			if($region[$i]==0){
				unset($ret[$i]);
			} 	
		}

		return Response::json($ret);

	}

	public function getFakta($topik,$variabel,$regional){

		$kodeTopikVariabel = TopikVariabel::where('kode_topik','=',$topik)->where('kode_variabel','=',$variabel)->get();

		$fakta = Fakta::where('kode_topik_variabel','=',$kodeTopikVariabel[0]["kode"])->get();

		$kodeItem = array();
		$yearDat = array();
		$i=0;
		$temp=array();

		foreach($fakta as $fact){
			 
			$ssItem = ItemKategori::find($fact["kode_item_kategori"])["nama"];
			$ssWilayah = Wilayah::find($fact["kode_wilayah"]);

			if($regional==1){
				if($ssWilayah["kode_parent"]!=="0") continue;	
			}
			else if($regional==2){
				if($ssWilayah["tipe"]!=1) continue;
			}
			else if($regional==3){
				if($ssWilayah["tipe"]!=2) continue;
			}

			$temp[$i]=$fact;
			$temp[$i]["kode_item_kategori"] = $ssItem;
			$temp[$i]["kode_wilayah"] = $ssWilayah["nama"];

			$kodeItem[$i] = $ssItem;
			$yearDat[$i] = $fakta[$i]["tahun"];

			$i++;
		}
		
		$kodeItem = array_unique($kodeItem);
		$yearDat = array_unique($yearDat);

		$ret = array();
		$ret["Year"] = $yearDat;
		$ret["kodeItem"] = $kodeItem;
		$ret["data"] = $temp;


		return Response::json($ret);
	}

}
