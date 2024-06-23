<div class="calculation">
  <div class="item">
    <div class="top">
      <b class="mini-title"><span>1.</span> Тип химии</b>
      <input type="checkbox" id="help-chemistry" name="type-help">
      <label for="help-chemistry">
        <div class="style-check"></div>
        <span>Помочь с выбором</span>
      </label>
    </div>
    <div class="bot">
      <input type="radio" checked id="chem-1" name="type" value="Li-ion">
      <label for="chem-1">
        <b>Li-ion</b>
        <p>Литий ионный</p>
      </label>
      <input type="radio"  id="chem-2" name="type" value="LiPol">
      <label for="chem-2">
        <b>LiPol</b>
        <p>Литий ионный полимерный</p>
      </label>
      <input type="radio"  id="chem-3" name="type" value="LiFeP04">
      <label for="chem-3">
        <b>LiFeP04</b>
        <p>Литий ионный железо-фосфатный</p>
      </label>
      <input type="radio"  id="chem-4" name="type" value="LTO">
      <label for="chem-4">
        <b>LTO</b>
        <p>Литий ионный титанатный</p>
      </label>
    </div>
  </div>
  <div class="item">
    <div class="top">
      <b class="mini-title"><span>2.</span> Корпус</b>
      <input type="checkbox" id="help-corp" name="corp-help">
      <label for="help-corp">
        <div class="style-check"></div>
        <span>Помочь с выбором</span>
      </label>
    </div>
    <div class="bot">
      <input type="radio" checked id="corp-1" name="corp" value="Пластиковый корпус">
      <label for="corp-1">
        <b>Пластиковый корпус</b>
      </label>
      <input type="radio"  id="corp-2" name="corp" value="Пластиковый защищенный кейс">
      <label for="corp-2">
        <b>Пластиковый защищенный кейс</b>
      </label>
      <input type="radio"  id="corp-3" name="corp" value="Металлический корпус">
      <label for="corp-3">
        <b>Металлический корпус</b>
      </label>
      <input type="radio"  id="corp-4" name="corp" value="Бескорпусный АКБ">
      <label for="corp-4">
        <b>Бескорпусный АКБ</b>
        <p>в стеклопластике или пвх пленке</p>
      </label>
    </div>
  </div>
  <div class="item">
    <div class="top">
      <b class="mini-title"><span>3.</span> Характеристики</b>
    </div>
    <div class="range">
      <div class="range-item">
        <p>Напряжение V (B)</p>
        <input type="text" class="view-val" value="12" data-min="12" data-max="96">
        <input type="range" id="range-V" class="range-input"
          data-min="12"
          data-max="96"
          data-step="1"
          data-default="12"
        >
        <div class="meta">
          <span>12 В</span>
          <span>96 В</span>
        </div>
      </div>
    </div>
    <div class="range">
      <div class="range-item">
        <p>Емкость Ah (Ач)</p>
        <input type="text" class="view-val" value="50" data-min="1" data-max="1000">
        <input type="range" id="range-AH" class="range-input"
          data-min="1"
          data-max="1000"
          data-step="1"
          data-default="50"
        >
        <div class="meta">
          <span>1 Ач</span>
          <span>1000 Ач</span>
        </div>
      </div>
    </div>
    <div class="range">
      <div class="range-item">
        <p>Ток разряда (постоянный), А</p>
        <input type="text" class="view-val" value="20" data-min="1" data-max="500">
        <input type="range" id="range-A" class="range-input"
          data-min="1"
          data-max="500"
          data-step="1"
          data-default="20"
        >
        <div class="meta">
          <span>1 А</span>
          <span>500 А</span>
        </div>
      </div>
    </div>
  </div>

</div>