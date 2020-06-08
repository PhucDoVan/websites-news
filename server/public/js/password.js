"use strict";

/**
 * Password Utils
 *
 * @type {{_pattern: RegExp, _getRandomByte: _getRandomByte, generate: (function(*=): string)}}
 */
const Password = {

  // Content a- z and A-Z 0-9 and "_@."
  _pattern: /[a-zA-Z0-9_!@#$%^&*.]/,

  /**
   * Get random byte
   * @returns {number}
   * @private
   */
  _getRandomByte: function () {
    if (window.crypto && window.crypto.getRandomValues) {
      var result = new Uint8Array(1);
      window.crypto.getRandomValues(result);
      return result[0];
    } else if (window.msCrypto && window.msCrypto.getRandomValues) {
      var result = new Uint8Array(1);
      window.msCrypto.getRandomValues(result);
      return result[0];
    } else {
      return Math.floor(Math.random() * 256);
    }
  },

  /**
   * Get random String
   * @returns {string}
   * @private
   */
  _getRandomString: function (length) {
    return Array.apply(null, {'length': length})
      .map(function () {
        while (true) {
          const result = String.fromCharCode(this._getRandomByte());
          if (this._pattern.test(result)) {
            return result;
          }
        }
      }, this)
      .join('');
  },

  /**
   * Generate string base _pattern
   *
   * @param length
   * @param validatePattern
   * @returns {string}
   */
  generate: function (length, validatePattern = null) {
    let generateString;
    let retries = 10;
    while (retries > 0) {
      generateString = this._getRandomString(length);
      if (validatePattern === null || validatePattern.test(generateString)) {
        return generateString;
      }
      retries--;
    }
    throw new Error("パスワードを作成時にエラーが発生しました。");
  },

};
