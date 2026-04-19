(function(window){
  'use strict';

  function $(selector, root){ return (root || document).querySelector(selector); }
  function $all(selector, root){ return Array.from((root || document).querySelectorAll(selector)); }

  function toggleInfo(id){
    const box = document.getElementById(id || 'infoContent');
    if(!box) return;

    if(box.classList.contains('note-info-content')){
      box.classList.toggle('is-open');
      return;
    }

    box.classList.toggle('show');
    box.style.display = box.classList.contains('show') ? 'block' : 'none';
  }

  function getSelected(name, root){
    const el = (root || document).querySelector('input[name="' + name + '"]:checked');
    return el ? el.value : null;
  }

  function normalizeDecimalString(value){
    if(value === null || value === undefined) return '';

    let str = String(value).trim().replace(/\s+/g, '');
    if(!str) return '';

    if(str.includes(',') && str.includes('.')){
      if(str.lastIndexOf(',') > str.lastIndexOf('.')){
        str = str.replace(/\./g, '').replace(',', '.');
      } else {
        str = str.replace(/,/g, '');
      }
    } else {
      str = str.replace(',', '.');
    }

    return str;
  }

  function parseDecimal(value){
    const normalized = normalizeDecimalString(value);
    return normalized ? Number(normalized) : NaN;
  }

  function formatNumber(value, decimals){
    const n = Number(value);
    if(value === null || value === undefined || Number.isNaN(n)) return '-';

    const d = typeof decimals === 'number' ? decimals : 2;

    return n
      .toFixed(d)
      .replace(/\.00$/, '')
      .replace(/(\.\d*?)0+$/, '$1')
      .replace('.', ',');
  }

  function formatPercent(value, decimals){
    const n = Number(value);
    if(Number.isNaN(n)) return '-';
    return formatNumber(n, typeof decimals === 'number' ? decimals : 0) + '%';
  }

  function safeSetText(id, value){
    const el = typeof id === 'string' ? document.getElementById(id) : id;
    if(el) el.textContent = value;
  }

  function safeSetHTML(id, value){
    const el = typeof id === 'string' ? document.getElementById(id) : id;
    if(el) el.innerHTML = value;
  }

  function showElement(id, className){
    const el = typeof id === 'string' ? document.getElementById(id) : id;
    if(!el) return;
    if(className) el.classList.remove(className);
    else el.hidden = false;
  }

  function hideElement(id, className){
    const el = typeof id === 'string' ? document.getElementById(id) : id;
    if(!el) return;
    if(className) el.classList.add(className);
    else el.hidden = true;
  }

  function showValidityWarning(boxId, textId, text){
    showElement(boxId || 'validityWarning', 'note-hidden');
    safeSetText(textId || 'validityWarningText', text || '');
  }

  function hideValidityWarning(boxId, textId){
    hideElement(boxId || 'validityWarning', 'note-hidden');
    safeSetText(textId || 'validityWarningText', '');
  }

  function applySelectionBorder(selector){
    $all(selector || '.note-check, .choice-check, .choice-radio, .factor-check, .factor-radio, .caprini-radio').forEach(function(input){
      const label = document.querySelector('label[for="' + input.id + '"]');
      if(!label) return;
      label.classList.toggle('is-selected', !!input.checked);
    });
  }

  function bindSelectionSync(selector){
    const resolvedSelector = selector || '.note-check, .choice-check, .choice-radio, .factor-check, .factor-radio, .caprini-radio';

    document.addEventListener('change', function(e){
      if(e.target.matches(resolvedSelector)){
        applySelectionBorder(resolvedSelector);
      }
    });

    applySelectionBorder(resolvedSelector);
  }

  function bindScoreDomainSelection(selector){
    const inputSelector = selector || '.score-option-input';

    document.addEventListener('change', function(e){
      if(!e.target.matches(inputSelector)) return;

      const name = e.target.name;
      document.querySelectorAll('input[name="' + name + '"]').forEach(function(input){
        const label = input.nextElementSibling;
        if(label && label.classList.contains('score-option')){
          label.classList.toggle('is-selected', input.checked);
        }
      });
    });

    document.querySelectorAll(inputSelector).forEach(function(input){
      const label = input.nextElementSibling;
      if(label && label.classList.contains('score-option')){
        label.classList.toggle('is-selected', input.checked);
      }
    });
  }

  function drugClassToCss(clase){
    const map = {
      opioid:'drug-opioid',
      local:'drug-local',
      inductor:'drug-inductor',
      neuromuscular:'drug-neuromuscular',
      vasoactive:'drug-vasoactive',
      atropine:'drug-atropine',
      other:'drug-other',
      reversal_opioid:'drug-reversal-opioid',
      reversal_local:'drug-reversal-local',
      reversal_inductor:'drug-reversal-inductor',
      reversal_neuromuscular:'drug-reversal-neuromuscular',
      reversal_vasoactive:'drug-reversal-vasoactive',
      reversal_atropine:'drug-reversal-atropine',
      reversal_other:'drug-reversal-other'
    };
    return map[clase] || 'drug-other';
  }

  function createDrugOption(args){
    const id = args.id;
    const css = drugClassToCss(args.className || args.drugClass || 'other');

    return [
      '<div>',
      '  <input class="note-check note-trigger" type="radio" name="' + args.name + '" id="' + id + '" value="' + args.value + '"' + (args.checked ? ' checked' : '') + '>',
      '  <label class="note-option ' + css + '" for="' + id + '">',
      args.icon ? '    <i class="fa-solid ' + args.icon + '"></i>' : '',
      '    ' + args.label,
      args.sub ? '    <small>' + args.sub + '</small>' : '',
      '  </label>',
      '</div>'
    ].join('\n');
  }

  function normalizeText(value){
    return String(value || '')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .toLowerCase()
      .trim();
  }

  function filterItems(items, query, fields){
    const normalizedQuery = normalizeText(query);
    if(!normalizedQuery) return items.slice();

    const fieldList = Array.isArray(fields) && fields.length ? fields : null;

    return items.filter(function(item){
      if(!fieldList){
        return normalizeText(JSON.stringify(item)).includes(normalizedQuery);
      }

      return fieldList.some(function(field){
        return normalizeText(item && item[field]).includes(normalizedQuery);
      });
    });
  }

  function bindSearchFilter(config){
    if(!config || !config.input || !config.items || !config.render) return;

    const input = typeof config.input === 'string' ? document.getElementById(config.input) || document.querySelector(config.input) : config.input;
    if(!input) return;

    const items = Array.isArray(config.items) ? config.items : [];
    const fields = Array.isArray(config.fields) ? config.fields : null;
    const render = config.render;
    const emptyState = typeof config.emptyState === 'function' ? config.emptyState : null;

    function update(){
      const filtered = filterItems(items, input.value, fields);
      render(filtered, input.value);

      if(emptyState){
        emptyState(filtered, input.value);
      }
    }

    input.addEventListener('input', update);
    update();
  }

  function bindSelectableSearchItems(selector, options){
    const resolvedSelector = selector || '.note-search-item';
    const selectedClass = (options && options.selectedClass) || 'is-selected';
    const activeAttr = (options && options.activeAttr) || 'aria-pressed';

    document.addEventListener('click', function(e){
      const item = e.target.closest(resolvedSelector);
      if(!item) return;

      document.querySelectorAll(resolvedSelector).forEach(function(node){
        node.classList.remove(selectedClass);
        if(node.hasAttribute(activeAttr)) node.setAttribute(activeAttr, 'false');
      });

      item.classList.add(selectedClass);
      if(item.hasAttribute(activeAttr)) item.setAttribute(activeAttr, 'true');
    });
  }

  function renderMobileDetailRows(rows){
    if(!Array.isArray(rows)) return '';

    return rows.map(function(row){
      return [
        '<div class="note-mobile-detail-row">',
        '  <div class="note-mobile-detail-label">' + row.label + '</div>',
        '  <div class="note-mobile-detail-value">' + row.value + '</div>',
        '</div>'
      ].join('\n');
    }).join('\n');
  }

  function bindChecklistItems(selector){
  const resolvedSelector = selector || '.note-checklist-item-input';

  function syncChecklistItem(input){
    const item = input.closest('.note-checklist-item');
    if(!item) return;
    item.classList.toggle('is-done', !!input.checked);
  }

  document.addEventListener('change', function(e){
    if(!e.target.matches(resolvedSelector)) return;
    syncChecklistItem(e.target);
  });

  document.querySelectorAll(resolvedSelector).forEach(syncChecklistItem);
}

function bindChecklistSections(config){
  const sectionSelector = (config && config.sectionSelector) || '.note-checklist-section';
  const headerSelector = (config && config.headerSelector) || '.note-checklist-section-head';

  document.addEventListener('click', function(e){
    const header = e.target.closest(headerSelector);
    if(!header) return;

    const section = header.closest(sectionSelector);
    if(!section) return;

    section.classList.toggle('is-collapsed');
  });
}

function expandAllChecklistSections(sectionSelector){
  document.querySelectorAll(sectionSelector || '.note-checklist-section').forEach(function(section){
    section.classList.remove('is-collapsed');
  });
}

function collapseAllChecklistSections(sectionSelector){
  document.querySelectorAll(sectionSelector || '.note-checklist-section').forEach(function(section){
    section.classList.add('is-collapsed');
  });
}

function getChecklistProgress(selector){
  const inputs = Array.from(document.querySelectorAll(selector || '.note-checklist-item-input'));
  const total = inputs.length;
  const done = inputs.filter(function(input){ return input.checked; }).length;
  const percent = total ? Math.round((done / total) * 100) : 0;

  return { total: total, done: done, percent: percent };
}

function bindChecklistProgress(config){
  const selector = (config && config.itemSelector) || '.note-checklist-item-input';
  const percentTarget = config && config.percentTarget;
  const countTarget = config && config.countTarget;
  const onUpdate = config && config.onUpdate;

  function update(){
    const progress = getChecklistProgress(selector);

    if(percentTarget){
      safeSetText(percentTarget, progress.percent + '%');
    }

    if(countTarget){
      safeSetText(countTarget, progress.done + ' / ' + progress.total);
    }

    if(typeof onUpdate === 'function'){
      onUpdate(progress);
    }
  }

  document.addEventListener('change', function(e){
    if(e.target.matches(selector)){
      update();
    }
  });

  update();
}

function buildChecklistText(config){
  const selector = (config && config.itemSelector) || '.note-checklist-item';
  const titleSelector = (config && config.titleSelector) || '.note-checklist-item-title';
  const noteSelector = (config && config.noteSelector) || '.note-checklist-item-note';
  const doneOnly = !!(config && config.doneOnly);

  return Array.from(document.querySelectorAll(selector)).map(function(item){
    const input = item.querySelector('.note-checklist-item-input');
    if(doneOnly && input && !input.checked) return null;

    const title = item.querySelector(titleSelector);
    const note = item.querySelector(noteSelector);

    const prefix = input && input.checked ? '[x] ' : '[ ] ';
    const titleText = title ? title.textContent.trim() : '';
    const noteText = note ? note.textContent.trim() : '';

    return prefix + titleText + (noteText ? ' — ' + noteText : '');
  }).filter(Boolean).join('\n');
}

function bindChecklistExport(config){
  if(!config || !config.output) return;

  const output = typeof config.output === 'string'
    ? document.getElementById(config.output) || document.querySelector(config.output)
    : config.output;

  if(!output) return;

  const itemSelector = config.itemSelector || '.note-checklist-item';
  const doneOnly = !!config.doneOnly;

  function update(){
    output.value = buildChecklistText({
      itemSelector: itemSelector,
      doneOnly: doneOnly
    });
  }

  document.addEventListener('change', function(e){
    if(e.target.matches('.note-checklist-item-input')){
      update();
    }
  });

  update();
}

  window.ClinicalNoteSystem = {
    $, $all,
    toggleInfo,
    getSelected,
    normalizeDecimalString,
    parseDecimal,
    formatNumber,
    formatPercent,
    safeSetText,
    safeSetHTML,
    showElement,
    hideElement,
    showValidityWarning,
    hideValidityWarning,
    applySelectionBorder,
    bindSelectionSync,
    bindScoreDomainSelection,
    drugClassToCss,
    createDrugOption,
    normalizeText,
    filterItems,
    bindSearchFilter,
    bindSelectableSearchItems,
    bindChecklistItems,
    bindChecklistSections,
    expandAllChecklistSections,
    collapseAllChecklistSections,
    getChecklistProgress,
    bindChecklistProgress,
    buildChecklistText,
    bindChecklistExport,
    renderMobileDetailRows
  };

  window.toggleInfo = window.toggleInfo || toggleInfo;
})(window);