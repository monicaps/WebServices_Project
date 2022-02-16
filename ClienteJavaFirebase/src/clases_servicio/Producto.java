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
public class Producto {
    private String ISBN;
    private String Autor;
    private String Nombre;
    private String Editorial;
    private int Año;
    private float Precio;
    
    public Producto(){
        Nombre="";
        ISBN="";
        Autor="";
        Editorial="";
        Año=0;
        Precio=0;
    }
    
    public Producto(String ISBN, String Nombre){
        this.ISBN=ISBN;
        this.Nombre=Nombre;
    }
    
    public Producto(String ISBN,String Autor,String Nombre, String Editorial,int Año, float Precio){
        this.ISBN=ISBN;
        this.Nombre=Nombre;
        this.Autor=Autor;
        this.Editorial=Editorial;
        this.Año=Año;
        this.Precio=Precio;
    }
    
    public void setNombre(String Nombre){
        this.Nombre=Nombre;
    }
    
    public void setISBN(String ISBN){
        this.ISBN=ISBN;
    }
    
    public void setAutor(String Autor){
        this.Autor=Autor;
    }
    
    public void setEditorial(String Editorial){
        this.Editorial=Editorial;
    }
    
    public void setAgno(int Año){
        this.Año=Año;
    }
    
    public void setPrecio(float Precio){
        this.Precio=Precio;
    }
    
    public String getNombre(){
        return Nombre;
    }
    
    public String getISBN(){
        return ISBN;
    }
    
    public String getAutor(){
        return Autor;
    }
    
    public int getAgno(){
        return Año;
    }
    
    public float getPrecio(){
        return Precio;
    }
    public String getEditorial(){
        return Editorial;
    }
}
