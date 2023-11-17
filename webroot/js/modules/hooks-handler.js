/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 17, 2023 2:55 PM ET
 * @release       a433e330c30db45ed9eaf70ee5d4ebbf88e92350 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class HooksHandler{constructor(e){this.main=e,this.main.debug,this.queue={}}add(e,u){this.queue[e]||(this.queue[e]=[]),this.queue[e].push(u)}call(e,...u){this.queue[e]&&(this.queue[e].forEach((e=>{e(...u)})),delete this.queue[e])}}