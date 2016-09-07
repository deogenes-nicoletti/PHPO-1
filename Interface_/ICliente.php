<?php

  namespace Interface_;

  interface ICliente
  {
    public function getEnderecoCobranca();
    public function setEnderecoCobranca($strEnderecoCobranca);

    public function getGrauImportancia();
    public function setGrauImportancia($intGrauImportancia);
  }
