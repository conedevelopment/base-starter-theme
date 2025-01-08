/* global tinymce */

tinymce.PluginManager.add('BaseShortcodes', function (editor) {
  editor.addButton('base_shortcodes_button', {
    text: 'Shortcode',
    icon: false,
    type: 'menubutton',
    menu: [
      {
        text: 'Button',
        value: '[button url="https://base.io" type="primary" target="_self"]Caption[/button]',
        onclick: function () {
          editor.insertContent(this.value());
        }
      },
      {
        text: 'Code',
        value: '[code id="##" /]',
        onclick: function () {
          editor.insertContent(this.value());
        }
      },
      {
        text: 'Responsive table',
        value: '[table][/table]',
        onclick: function () {
          editor.insertContent(this.value());
        }
      }
    ]
  });
});
