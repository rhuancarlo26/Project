<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Produto;
use App\TipoTreinamento;
use App\Treinamento;
use App\ControlePessoal;
use App\TreinamentoColaborador;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;


class TreinamentoController extends Controller
{

    public function controle(){

        $cp = ControlePessoal::orderby('matricula', 'ASC');
        return $cp->get();
    }

    public function treinamentoDetran(Request $request){

        $data = $request->all();
                
        $tipo_t = TipoTreinamento::get();

        $prod = Produto::get();
        
        $lists = $this->getListTab($data);

        $cp = ControlePessoal::whereNull('deleted_at')->whereNull('dt_demissao')->get();
        //$lists = Treinamento::get();

        $analista = ControlePessoal::whereNull('deleted_at')->whereNull('dt_demissao')->whereIn('cargo',[13])->get();

        $tabs = Treinamento::orderby('id','ASC')->get();
        
        
        return view('treinamentoDetran',compact('lists','tipo_t','prod','tabs','cp','analista'));

    }
   
    public function store(Request $request)
    {
        $request->validate([
            'mt_treinamento'=>'required'

        ]);
                
       $data = $request->all();

       $treinamento = Treinamento::create([
        'id_tipo_treinamento'=>$data['mt_treinamento'],
        'id_produto'=>$data['m_produto'],
        'data_inicio'=>$data['mdata_inicio'],
        'data_fim'=>$data['mdata_fim'],
        'carga_horaria'=>$data['carga_h'],
        'analista_resp'=>$data['m_analista'],
        'objetivo'=>$data['objetivo']
       ]);
       
       if($treinamento->id){
            foreach($request->trein_part as $id){
                TreinamentoColaborador::create([
                    'id_treinamento'=>$treinamento->id,
                    'id_colaborador'=>$id
                ]);
            }

       }
                    
        return redirect()->route('treinamentoDetran')->with('message','Treinamento cadastrado com sucesso!');
        
    }
      

    public function getListTab(array $data) {

        if(!empty(Auth::user()->perfil_acessos_id)){
            
            $sql = Treinamento::orderby('id', 'DESC');

            if(!empty($data['treinamento'])){

                $sql->where('id_tipo_treinamento',$data['treinamento']);

            }

            if(!empty($data['produto'])){

                $sql->where('id_produto',$data['produto']);

            }
            
            if(!empty($data['data_inicio'])){

                $sql->where('data_inicio',$data['data_inicio']);

            }

        }

        return $sql->paginate(10);
    }

    public function visualizar(Request $request){

        $id = $request->input('id');
 
        if(!empty($id)){
            $data = Treinamento::where('id',$id)->get();

            $colab = TreinamentoColaborador::where('id_treinamento',$id)->get();

            foreach($data as $item){
                $result = $item;
            }

            $idColab = $colab->pluck('id_colaborador');
            

            
            $dados['success'] = true;
            $dados['message'] = 'sucesso';
            $dados['result'] = $result;
            $dados['colaborador'] = $idColab;

        }
        else{
    
            $dados['success'] = false;
            $dados['message'] = 'falha';
        }

        echo json_encode($dados);
        
        return;
    }


    public function modal(Request $request){

        $id = $request->input('id');

        $data = Treinamento::where('id',$id)->get();

        $colaborador_treinamento = TreinamentoColaborador::join('controle_pessoal','controle_pessoal.id_registro','treinamento_colaborador.id_colaborador')
        ->select(
            'id_colaborador',
            'nome'
        );

        $colaborador_treinamento->where('id_treinamento',$id)->get();
        
        

        foreach($data as $item) {
            $result = $item;
        }

        foreach($colaborador_treinamento as $item){
            $colaborador = $item;
        }

        $dados['success'] = true;
        $dados['message'] = 'sucesso';
        $dados['result'] = $result;
        $dados['colaborador'] = $colaborador;

        return json_encode($dados);
    }




}
