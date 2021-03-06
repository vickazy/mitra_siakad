<?php
// Author : SIAKAD TEAM
// Email  : setio.dewo@gmail.com
// Start  : 14 Oktober 2008

// *** Parameters ***
if ($_SESSION['_LevelID'] == 1) {
  $_MhswID = GetSetVar('_MhswID');
}
elseif ($_SESSION['_LevelID'] == 120) {
  $_MhswID = $_SESSION['_Login'];
}
else die(ErrorMsg('Error',
  "Anda tidak berhak menjalankan modul ini."));

// *** Main ***
TampilkanJudul("Ubah Password Mahasiswa");
$gos = (empty($_REQUEST['gos']))? 'frmPwd' : $_REQUEST['gos'];
$gos($_MhswID);

// *** Functions ***
function frmPwd($_MhswID) {
  if ($_SESSION['_LevelID'] == 1) {
    $_NIM = "<input type=text name='_MhswID' value='$_MhswID' size=20 maxlength=50 />"; 
  }
  else {
    $_NIM = "<input type=hidden name='_MhswID' value='$_MhswID' /><b>$_MhswID</b>";
  }
  $mhsw = GetFields('mhsw', "KodeID='".KodeID."' and MhswID", $_MhswID,
    "MhswID, Nama, ProdiID, `Password`");
  echo <<<ESD
  <table class=box cellspacing=1 align=center width=600>
  <form name='frmPwd' action='?' method=POST onSubmit="return CheckPassword(frmPwd)">
  <input type=hidden name='gos' value='SimpanPwd' />
  
  <tr><td class=inp width=80>NIM:</td>
      <td class=ul width=80>$_NIM</td>
      <td class=inp width=80>Nama Mhsw:</td>
      <td class=ul><b>$mhsw[Nama]</b>&nbsp;</td>
      </tr>
      
  <tr><td class=inp valign=top>Pwd Baru:</td>
      <td class=ul valign=top>
        <input type=password name='PWD1' size=10 maxlength=10 />
      </td>
      <td class=inp valign=top>Pwd Baru:</td>
      <td class=ul valign=top>
        <input type=password name='PWD2' size=20 maxlength=10 /><br />
        *) tuliskan password baru sekali lagi
      </td>
      </tr>
  <tr><td class=ul colspan=4 align=center>
      <input type=submit name='Simpan' value='Simpan Password Baru' />
      </td>
      </tr>
  
  </form>
  </table>
  
  <script>
  function CheckPassword(frm) {
    var pesan = "";
    if (frm.PWD1.value == '' || frm.PWD2.value == '')
      pesan += "Password tidak boleh kosong. \\n";
    if (frm.PWD1.value.length < 4)
      pesan += "Password harus lebih dari 4 karakter. \\n";
    if (frm.PWD1.value != frm.PWD2.value)
      pesan += "Ketikkan password baru 2 kali dengan benar. \\n";
    if (pesan != "") alert(pesan);
    return pesan == "";
  }
  </script>
ESD;
}
function SimpanPwd($_MhswID) {
  $_MhswID = sqling($_REQUEST['_MhswID']);
  $PWD1 = sqling($_REQUEST['PWD1']);
  $PWD2 = sqling($_REQUEST['PWD2']);
  $s = "update mhsw 
    set `Password`=LEFT(PASSWORD('$PWD1'), 10) 
    where KodeID = '".KodeID."'
      and MhswID = '$_MhswID' ";
  $r = _query($s);
  BerhasilSimpan("?mnux=$_SESSION[mnux]&gos=&_MhswID=$_MhswID", 1000); 
}
?>
