/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Cookie{set(e,t,o,i){let n=e+"="+t+";";if(o){const e=new Date;e.setTime(e.getTime()+o),n+="expires="+e.toUTCString()}i&&(n+=";path=/"+i),domain&&(n+=";domain=/"+domain),document.cookie=n}get(e){let t=e+"=",o=document.cookie.split(";");for(let e=0;e<o.length;e++){let i=o[e];for(;" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}}remove(e,t,o){this.get(e)&&(document.cookie=e+"="+(t?";path="+t:"")+(o?";domain="+o:"")+";expires=Thu, 01 Jan 1970 00:00:01 GMT")}}