/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Wed, Jan 10, 2024 4:53 PM ET
 * @release       f39df71e611dee1cda1bc6540ca6aa0707b9a278 [page-tree]
 * @copyright     Copyright (c) 2024, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class HooksHandler{constructor(e){this.main=e,this.main.debug,this.queue={}}add(e,u){this.queue[e]||(this.queue[e]=[]),this.queue[e].push(u)}call(e,...u){this.queue[e]&&(this.queue[e].forEach((e=>{e(...u)})),delete this.queue[e])}}