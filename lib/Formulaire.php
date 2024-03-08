<?php
class Formulaire{
	private $method;
	private $action;
	private $nom;
	private $style;
	private $formulaireToPrint;
	private $enctype;
		
	private $ligneComposants = array();
	private $tabComposants = array();
	
	public function __construct($uneMethode, $uneAction , $unNom,$unStyle ,$enctype =null ){
		$this->method = $uneMethode;
		$this->action =$uneAction;
		$this->nom = $unNom;
		$this->style = $unStyle;
		$this->enctype = $enctype;
	}
	
	public function concactComposants($unComposant , $autreComposant ){
		$unComposant .=  $autreComposant;
		return $unComposant ;
	}
	
    public function ajouterComposantLigne($unComposant, $unNbCols, $classes = array()) {
        $temp = "<td";
        if ($unNbCols > 1) {
            $temp .= " colspan ='" . $unNbCols . "' ";
        }
        if (!empty($classes)) {
            $temp .= " class='" . $classes . "' ";
        }

        $temp .= ">" . $unComposant . "</td>";
        $this->ligneComposants[] = $temp;
    }
	
	public function ajouterComposantTab(){
		$this->tabComposants[] = $this->ligneComposants;
		$this->ligneComposants = [];
	}
	
	public function creerLabel($unLabel , $uneClass){
		$composant = "<label class =" .$uneClass. " >" . $unLabel . "</label>";
		return $composant;
	}
	
	public function creerInputTexte($unNom, $unId, $uneValue , $required , $placeholder, $readOnly){
		$composant = "<input type = 'text' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( $required == 1){
			$composant .= " required ";
		}
		if ( $readOnly == 1){
			$composant .= " readonly ";
		}
		$composant .= "/>";
		return $composant;
	}
	
	public function creerInputPass($unNom, $unId, $uneValue , $required){
		$composant = "<input type = 'password' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		
		if ( $required == 1){
			$composant .= " required ";
		}
		
		$composant .= "/>";
		return $composant;
	}
	
	public function creerLabelFor($unFor,  $unLabel){
		$composant = "<label for='" . $unFor . "'>" . $unLabel . "</label>";
		return $composant;
	}

	public function creerLien($uneValeur, $unLien){
		$composant = "<a href='".$unLien ."'>". $uneValeur . "</a>";
		return $composant;
	}

	public function creerSelect($unNom, $unId, $unLabel, $options, $onChange = null, $selectedValue = null) {
		$composant = "<select name='" . $unNom . "' id='" . $unId . "' ";
		if ($onChange) {
			$composant .= "onchange='" . $onChange . "(this)'";
		}
		$composant .= ">";
	
		foreach ($options as $option) {
			$composant .= "<option value='" . $option . "'";
			// Vérifie si l'option est celle sélectionnée et ajoute l'attribut "selected" si c'est le cas
			if ($selectedValue !== null && $option === $selectedValue) {
				$composant .= " selected";
			}
			$composant .= ">" . $option . "</option>";
		}
	
		$composant .= "</select>";
		return $composant;
	}
		
	
	public function creerInputSubmit($unNom, $unId, $uneValue){
		$composant = "<input type = 'submit' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= "value = \"" . $uneValue . "\"/> ";
		return $composant;
	}

	public function creerInputImage($unNom, $unId, $uneSource){
		$composant = "<input type = 'image' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= "src = '" . $uneSource . "'/> ";
		return $composant;
	}
	
	public function creerFormulaire(){
		$this->formulaireToPrint = "<form method = '" .  $this->method . "' ";
		$this->formulaireToPrint .= "action = '" .  $this->action . "' ";
		$this->formulaireToPrint .= "name = '" .  $this->nom . "' ";
		$this->formulaireToPrint .= "enctype = '" .  $this->enctype . "' ";
		$this->formulaireToPrint .= "class = '" .  $this->style . "' ><table>";
		

		foreach ($this->tabComposants as $uneLigneComposants){
			$this->formulaireToPrint .= "<tr>";
			foreach ($uneLigneComposants as $unComposant){
				$this->formulaireToPrint .= $unComposant ;
			}
			$this->formulaireToPrint .= "</tr>";
		}
		$this->formulaireToPrint .= "</table></form>";
		return $this->formulaireToPrint ;
	}
	
	public function afficherFormulaire(){
		echo $this->formulaireToPrint ;
	}

	public function desafficherFormulaire(){
		$this->formulaireToPrint = null;
	}

	public function creerInputNumber($unNom, $unId){
		$composant = "<input type = 'number' name = '" . $unNom . "' id = '" . $unId . "' min=0";
		return $composant;
	}

	public function creerInputMail($unNom, $unId, $uneValue , $required , $placeholder, $readOnly){
		$composant = "<input type = 'email' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( $required == 1){
			$composant .= " required ";
		}
		if ( $readOnly == 1){
			$composant .= " readonly ";
		}
		$composant .= "/>";
		return $composant;
	}

	public function creerInputMobile($unNom, $unId, $uneValue , $required =null , $placeholder = null, $readOnly = null){
		$composant = "<input type = 'tel' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( $required == 1){
			$composant .= " required ";
		}
		if ( $readOnly == 1){
			$composant .= " readonly ";
		}
		$composant .= "/>";
		return $composant;
	}
	
	public function creerInputNumberV($unNom, $unId, $uneValue, $min = null , $max = null){
		$composant = "<input type='number' name='" . htmlspecialchars($unNom) . "' id='" . htmlspecialchars($unId) . "' value='" . htmlspecialchars($uneValue) . "'";
		if(isset($min)){
			$composant .= " min='" . htmlspecialchars($min) . "'";
		}
		if(isset($max)){
			$composant .= " max='" . htmlspecialchars($max) . "'";
		}
		$composant .= "/>";
		return $composant;
	}

	public function creerInputDate($unNom, $unId, $uneValue){
		$composant = "<input type = 'date' name = '" . $unNom . "' id = '" . $unId . "' value = '".$uneValue."'/>";
		return $composant;
	}
	
	public function creerInputTime($unNom, $unId, $uneValue){
		$composant = "<input type = 'time' name = '" . $unNom . "' id = '" . $unId . "' value = '".$uneValue."'/>";
		return $composant;
	}

	public function creerInputHidden($unNom, $unId, $uneValue){
		$composant = "<input type = 'hidden' name = '" . $unNom . "' id = '" . $unId . "' value = '".$uneValue."'/>";
		return $composant;
	}

	public function creerTextArea($unNom, $unid, $unevalue, $rows, $cols, $required, $readOnly){
		$composant = "<textarea id=".$unid." name=".$unNom." rows=".$rows." cols=".$cols;
		if ( $required == 1){
			$composant .= " required ";
		}
		if($readOnly ==1 ){
			$composant.= "readOnly";
		}
		$composant.= ">".$unevalue."</textarea>";
		return $composant;
	}

	public function creerImg($path, $class){
		$composant = "<img src=".$path." class =".$class." />";
		return $composant;
	}

	public function creerButton($unNom, $unId, $uneValue , $value){
		$composant = "<button name=".$unNom." id=".$unId." value=".$value.">".$uneValue."</button>";
		return $composant;
	}

	public function creerInputFile($unNom, $id, $accept){
		$composant = "<input type='file' id=".$id." name=".$unNom." accept = ".$accept.">";
		return $composant;
	}
	
}