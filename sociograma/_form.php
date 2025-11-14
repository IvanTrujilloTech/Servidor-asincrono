<form action="process.php" method="POST" novalidate>
  <fieldset>
    <legend>1. Identificación</legend>

    <div class="form-group">
      <label for="nombre">Nombre y Apellidos</label>
      <input type="text" id="nombre" name="nombre" value="<?= e(old('nombre', $old)) ?>" required minlength="3" maxlength="100">
      <?= field_error('nombre', $errors) ?>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e(old('email', $old)) ?>" placeholder="opcional@tudominio.com">
      <?= field_error('email', $errors) ?>
    </div>

    <div class="form-group">
      <label for="grupo">Grupo</label>
      <select id="grupo" name="grupo" required>
        <option value="" <?= is_selected('grupo', '', $old) ?>>-- Selecciona tu grupo --</option>
        <option value="DAW1" <?= is_selected('grupo', 'DAW1', $old) ?>>DAW 1º</option>
        <option value="DAW2" <?= is_selected('grupo', 'DAW2', $old) ?>>DAW 2º</option>
      </select>
      <?= field_error('grupo', $errors) ?>
    </div>

    <div class="form-group">
      <label for="edad">Edad</label>
      <input type="number" id="edad" name="edad" value="<?= e(old('edad', $old)) ?>" min="16" max="99">
      <?= field_error('edad', $errors) ?>
    </div>
  </fieldset>

  <fieldset>
    <legend>2. Preferencias de Colaboración</legend>
    <div class="form-group">
      <label for="preferido_1">Compañero preferido 1</label>
      <input type="text" id="preferido_1" name="preferido_1" value="<?= e(old('preferido_1', $old)) ?>" required>
      <?= field_error('preferido_1', $errors) ?>
    </div>
    <div class="form-group">
      <label for="preferido_2">Compañero preferido 2</label>
      <input type="text" id="preferido_2" name="preferido_2" value="<?= e(old('preferido_2', $old)) ?>">
    </div>
    <div class="form-group">
      <label for="evitar_1">Compañero a evitar 1</label>
      <input type="text" id="evitar_1" name="evitar_1" value="<?= e(old('evitar_1', $old)) ?>" required>
      <?= field_error('evitar_1', $errors) ?>
    </div>
    <div class="form-group">
      <label for="motivo_preferencia">Motivo (Preferencias)</label>
      <textarea id="motivo_preferencia" name="motivo_preferencia" maxlength="300"><?= e(old('motivo_preferencia', $old)) ?></textarea>
    </div>
  </fieldset>

  <fieldset>
    <legend>3. Rol y Habilidades</legend>
    <div class="form-group">
      <label>Rol habitual en proyectos</label>
      <div class="radio-group">
        <label><input type="radio" name="rol_habitual" value="frontend" <?= is_radio_checked('rol_habitual', 'frontend', $old) ?>> Frontend</label>
        <label><input type="radio" name="rol_habitual" value="backend" <?= is_radio_checked('rol_habitual', 'backend', $old) ?>> Backend</label>
        <label><input type="radio" name="rol_habitual" value="fullstack" <?= is_radio_checked('rol_habitual', 'fullstack', $old) ?>> Full-Stack</label>
        <label><input type="radio" name="rol_habitual" value="devops" <?= is_radio_checked('rol_habitual', 'devops', $old) ?>> DevOps / Infra</label>
        <label><input type="radio" name="rol_habitual" value="gestion" <?= is_radio_checked('rol_habitual', 'gestion', $old) ?>> Gestión / PM</label>
      </div>
      <?= field_error('rol_habitual', $errors) ?>
    </div>
    <div class="form-group">
      <label for="lenguaje_fuerte">Lenguaje donde te sientes más fuerte</label>
      <select id="lenguaje_fuerte" name="lenguaje_fuerte" required>
        <option value="" <?= is_selected('lenguaje_fuerte', '', $old) ?>>-- Selecciona un lenguaje --</option>
        <option value="php" <?= is_selected('lenguaje_fuerte', 'php', $old) ?>>PHP</option>
        <option value="js" <?= is_selected('lenguaje_fuerte', 'js', $old) ?>>JavaScript</option>
        <option value="python" <?= is_selected('lenguaje_fuerte', 'python', $old) ?>>Python</option>
        <option value="java" <?= is_selected('lenguaje_fuerte', 'java', $old) ?>>Java</option>
        <option value="csharp" <?= is_selected('lenguaje_fuerte', 'csharp', $old) ?>>C#</option>
        <option value="otro" <?= is_selected('lenguaje_fuerte', 'otro', $old) ?>>Otro</option>
      </select>
      <?= field_error('lenguaje_fuerte', $errors) ?>
    </div>
    <div class="form-group">
      <label for="experiencia_proyectos">Nº de proyectos (reales o académicos) terminados</label>
      <input type="number" id="experiencia_proyectos" name="experiencia_proyectos" value="<?= e(old('experiencia_proyectos', $old, 0)) ?>" min="0" max="100">
    </div>
    <div class="form-group">
      <label for="nivel_git">Tu nivel de Git (1 = Básico, 5 = Experto)</label>
      <input type="number" id="nivel_git" name="nivel_git" value="<?= e(old('nivel_git', $old, 1)) ?>" min="1" max="5">
      <?= field_error('nivel_git', $errors) ?>
    </div>
  </fieldset>

  <fieldset>
    <legend>4. Dinámica y Comunicación</legend>
    <div class="form-group">
      <label>Preferencia de comunicación</label>
      <div class="radio-group">
        <label><input type="radio" name="comunicacion_pref" value="sincrona" <?= is_radio_checked('comunicacion_pref', 'sincrona', $old) ?>> Síncrona (Reuniones, llamadas)</label>
        <label><input type="radio" name="comunicacion_pref" value="asincrona" <?= is_radio_checked('comunicacion_pref', 'asincrona', $old) ?>> Asíncrona (Chat, email, issues)</label>
        <label><input type="radio" name="comunicacion_pref" value="mixta" <?= is_radio_checked('comunicacion_pref', 'mixta', $old) ?>> Mixta (Ambas)</label>
      </div>
      <?= field_error('comunicacion_pref', $errors) ?>
    </div>
    <div class="form-group">
      <label>Herramientas de gestión preferidas (múltiple)</label>
      <div class="checkbox-group">
        <label><input type="checkbox" name="herramientas[]" value="github" <?= is_checkbox_checked('herramientas', 'github', $old) ?>> GitHub (Issues, Projects)</label>
        <label><input type="checkbox" name="herramientas[]" value="discord" <?= is_checkbox_checked('herramientas', 'discord', $old) ?>> Discord</label>
        <label><input type="checkbox" name="herramientas[]" value="slack" <?= is_checkbox_checked('herramientas', 'slack', $old) ?>> Slack</label>
        <label><input type="checkbox" name="herramientas[]" value="trello" <?= is_checkbox_checked('herramientas', 'trello', $old) ?>> Trello</label>
        <label><input type="checkbox" name="herramientas[]" value="jira" <?= is_checkbox_checked('herramientas', 'jira', $old) ?>> Jira</label>
        <label><input type="checkbox" name="herramientas[]" value="notion" <?= is_checkbox_checked('herramientas', 'notion', $old) ?>> Notion</label>
      </div>
      <?= field_error('herramientas', $errors) // Error general para el grupo ?>
    </div>
    <div class="form-group">
      <label for="disponibilidad_inicio">Disponibilidad (Hora inicio)</label>
      <input type="time" id="disponibilidad_inicio" name="disponibilidad_inicio" value="<?= e(old('disponibilidad_inicio', $old)) ?>">
    </div>
    <div class="form-group">
      <label for="disponibilidad_fin">Disponibilidad (Hora fin)</label>
      <input type="time" id="disponibilidad_fin" name="disponibilidad_fin" value="<?= e(old('disponibilidad_fin', $old)) ?>">
    </div>
    <div class="form-group">
      <label for="frecuencia_reuniones">Frecuencia ideal de reuniones de equipo</label>
      <select id="frecuencia_reuniones" name="frecuencia_reuniones">
        <option value="diaria" <?= is_selected('frecuencia_reuniones', 'diaria', $old) ?>>Diaria (Daily)</option>
        <option value="semanal" <?= is_selected('frecuencia_reuniones', 'semanal', $old) ?> selected>Semanal</option>
        <option value="solo_necesario" <?= is_selected('frecuencia_reuniones', 'solo_necesario', $old) ?>>Solo si es necesario</option>
      </select>
    </div>
  </fieldset>

  <fieldset>
    <legend>5. Organización y Bienestar</legend>
    <div class="form-group">
      <label for="gestion_tiempo">¿Cómo valoras tu gestión del tiempo?</label>
      <select id="gestion_tiempo" name="gestion_tiempo">
        <option value="baja" <?= is_selected('gestion_tiempo', 'baja', $old) ?>>Baja (Suelo procrastinar)</option>
        <option value="media" <?= is_selected('gestion_tiempo', 'media', $old) ?> selected>Media (Aceptable)</option>
        <option value="alta" <?= is_selected('gestion_tiempo', 'alta', $old) ?>>Alta (Muy organizado)</option>
      </select>
    </div>
    <div class="form-group">
      <label for="manejo_estres">Manejo del estrés en entregas (1 = Mal, 5 = Muy bien)</label>
      <input type="number" id="manejo_estres" name="manejo_estres" value="<?= e(old('manejo_estres', $old, 3)) ?>" min="1" max="5" required>
      <?= field_error('manejo_estres', $errors) ?>
    </div>
    <div class="form-group">
      <label>Ambiente de trabajo preferido</label>
      <div class="radio-group">
        <label><input type="radio" name="ambiente_trabajo" value="silencio" <?= is_radio_checked('ambiente_trabajo', 'silencio', $old) ?>> Silencio absoluto</label>
        <label><input type="radio" name="ambiente_trabajo" value="musica" <?= is_radio_checked('ambiente_trabajo', 'musica', $old) ?>> Música (con cascos)</label>
        <label><input type="radio" name="ambiente_trabajo" value="ruido_blanco" <?= is_radio_checked('ambiente_trabajo', 'ruido_blanco', $old) ?>> Ruido de fondo (Cafetería, etc.)</label>
      </div>
    </div>
    <div class="form-group">
      <label for="resolucion_conflictos">¿Cómo afrontas un conflicto técnico con un compañero?</label>
      <textarea id="resolucion_conflictos" name="resolucion_conflictos" maxlength="300"><?= e(old('resolucion_conflictos', $old)) ?></textarea>
    </div>
  </fieldset>


  <fieldset>
    <legend>6. Logística</legend>
    <div class="form-group">
      <label for="dispositivo">Dispositivo principal de trabajo</label>
      <select id="dispositivo" name="dispositivo">
        <option value="portatil" <?= is_selected('dispositivo', 'portatil', $old) ?>>Portátil</option>
        <option value="sobremesa" <?= is_selected('dispositivo', 'sobremesa', $old) ?>>Sobremesa</option>
      </select>
    </div>
    <div class="form-group">
      <label>S.O. Preferido para desarrollar</label>
      <div class="radio-group">
        <label><input type="radio" name="so_preferido" value="windows" <?= is_radio_checked('so_preferido', 'windows', $old) ?>> Windows (con WSL)</label>
        <label><input type="radio" name="so_preferido" value="macos" <?= is_radio_checked('so_preferido', 'macos', $old) ?>> macOS</label>
        <label><input type="radio" name="so_preferido" value="linux" <?= is_radio_checked('so_preferido', 'linux', $old) ?>> Linux (Nativo)</label>
      </div>
      <?= field_error('so_preferido', $errors) ?>
    </div>
    <div class="form-group">
      <label for="color_equipo">Elige un "color" para tu equipo</label>
      <input type="color" id="color_equipo" name="color_equipo" value="<?= e(old('color_equipo', $old, '#007bff')) ?>">
    </div>
  </fieldset>


  <fieldset>
    <legend>7. Observaciones</legend>
    <div class="form-group">
      <label for="comentarios">Comentarios adicionales</label>
      <textarea id="comentarios" name="comentarios"><?= e(old('comentarios', $old)) ?></textarea>
    </div>
    <div class="form-group">
      <label for="fecha_respuesta">Fecha de la respuesta</label>
      <input type="date" id="fecha_respuesta" name="fecha_respuesta" value="<?= e(old('fecha_respuesta', $old, date('Y-m-d'))) ?>" required>
      <?= field_error('fecha_respuesta', $errors) ?>
    </div>
  </fieldset>

  <button type="submit" class="submit-btn">Enviar Respuesta</button>

</form>