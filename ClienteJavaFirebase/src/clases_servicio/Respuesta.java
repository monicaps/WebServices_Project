/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package clases_servicio;

/**
 *
 * @author Monica Portillo
 */
public class Respuesta {
    private int code;
    private String message;
    private String data;
    private String status;
    private boolean oferta;
    
    public Respuesta(){
        code=0;
        message="";
        data="";
        status="";
    }
    
    public Respuesta(int code, String message){
        this.code=code;
        this.message=message;
    }
    
    public Respuesta(int code, String message, String data,String status){
        this.code=code;
        this.message=message;
        this.data=data;
        this.status=status;
    }
    
    public Respuesta(int code, String message, String data,String status,boolean oferta){
        this.code=code;
        this.message=message;
        this.data=data;
        this.status=status;
        this.oferta=oferta;
    }
    
    public void setCode(int code){
        this.code=code;
    }
    
    public void setMessage(String message){
        this.message=message;
    }
    
    public void setData(String data){
        this.data=data;
    }
    
    public void setStatus(String status){
        this.status=status;
    }
    
    public void setOferta(Boolean oferta){
        this.oferta=oferta;
    }
    
    public int getCode(){
        return code;
    }
    
    public String getMessage(){
        return message;
    }
    
    public String getData(){
        return data;
    }
    
    public String getStatus(){
        return status;
    }
    
    public boolean getOferta(){
        return oferta;
    }
}
