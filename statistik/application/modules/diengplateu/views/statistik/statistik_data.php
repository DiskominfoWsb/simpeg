<script type="text/javascript">
    $(document).ready(function(){
        $('#idskpd').click(function(){
            refreshStatistik();
        });
    });
</script>

<div class="row-fluid">
    <div class="col-lg-12" id="result-graph">
        <?php
            switch($this->input->post('idkategori')){
                case "statjenkel" : $this->load->view('diengplateu/statistik/statistik_statjenkel_graph'); break;
                case "statagama" : $this->load->view('diengplateu/statistik/statistik_statagama_graph'); break;
                case "statgol" : $this->load->view('diengplateu/statistik/statistik_statgol_graph'); break;
                case "statpendid" : $this->load->view('diengplateu/statistik/statistik_statpendid_graph'); break;
                case "statjenjab" : $this->load->view('diengplateu/statistik/statistik_statjenjab_graph'); break;
                case "stateselon" : $this->load->view('diengplateu/statistik/statistik_stateselon_graph'); break;
                case "statdikstru" : $this->load->view('diengplateu/statistik/statistik_statdikstru_graph'); break;
                case "statfungsional" : $this->load->view('diengplateu/statistik/statistik_statfungsional_graph'); break;
                case "statdikfung" : $this->load->view('diengplateu/statistik/statistik_statdikfung_graph'); break;
                case "statdikfungjenjab" : $this->load->view('diengplateu/statistik/statistik_statdikfungjenjab_graph'); break;
                case "statfungsekdes" : $this->load->view('diengplateu/statistik/statistik_statfungsekdes_graph'); break;
                case "statskpd" : $this->load->view('diengplateu/statistik/statistik_statskpd_graph'); break;
                case "statguru" : $this->load->view('diengplateu/statistik/statistik_statguru_graph'); break;
                case "statmarital" : $this->load->view('diengplateu/statistik/statistik_statmarital_graph'); break;
                case "statkartu" : $this->load->view('diengplateu/statistik/statistik_statkartu_graph'); break;
            }
        ?>
    </div>
    <div class="col-lg-12">
        <?php
            switch($this->input->post('idkategori')){
                case "statjenkel" : $this->load->view('diengplateu/statistik/statistik_statjenkel'); break;
                case "statagama" : $this->load->view('diengplateu/statistik/statistik_statagama'); break;
                case "statgol" : $this->load->view('diengplateu/statistik/statistik_statgol'); break;
                case "statpendid" : $this->load->view('diengplateu/statistik/statistik_statpendid'); break;
                case "statjenjab" : $this->load->view('diengplateu/statistik/statistik_statjenjab'); break;
                case "stateselon" : $this->load->view('diengplateu/statistik/statistik_stateselon'); break;
                case "statdikstru" : $this->load->view('diengplateu/statistik/statistik_statdikstru'); break;
                case "statfungsional" : $this->load->view('diengplateu/statistik/statistik_statfungsional'); break;
                case "statdikfung" : $this->load->view('diengplateu/statistik/statistik_statdikfung'); break;
                case "statdikfungjenjab" : $this->load->view('diengplateu/statistik/statistik_statdikfungjenjab'); break;
                case "statfungsekdes" : $this->load->view('diengplateu/statistik/statistik_statfungsekdes'); break;
                case "statskpd" : $this->load->view('diengplateu/statistik/statistik_statskpd'); break;
                case "statguru" : $this->load->view('diengplateu/statistik/statistik_statguru'); break;
                case "statmarital" : $this->load->view('diengplateu/statistik/statistik_statmarital'); break;
                case "statkartu" : $this->load->view('diengplateu/statistik/statistik_statkartu'); break;
                case "statumum" : $this->load->view('diengplateu/statistik/statistik_statumum'); break;
            }
        ?>
    </div>
</div>