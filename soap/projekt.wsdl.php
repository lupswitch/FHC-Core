<?xml version="1.0" encoding="utf-8" ?>
<wsdl:definitions name="WS-Projekt" 
 targetNamespace="http://localhost/soap/" 
 xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" 
 xmlns:tns="http://localhost/soap/"    
 xmlns:xsd="http://www.w3.org/2001/XMLSchema"    
 xmlns:xsd1="http://localhost/soap/stip.xsd"    
 xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/">

<wsdl:types>
 <schema targetNamespace="http://localhost/soap/stip.xsd"
         xmlns="http://www.w3.org/2001/XMLSchema">
		 
		 
	<element name="Stipendiumsbezieher">
		<complexType>
			<sequence>
				<element minOccurs="1" maxOccurs="1" name="Semester" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Studienjahr" type="string" />
				<element minOccurs="1" maxOccurs="1" name="PersKz" type="string" />
				<element minOccurs="1" maxOccurs="1" name="SVNR" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Familienname" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Vorname" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Typ" type="string" />
			</sequence>
		</complexType>
	</element>

	
	<element name="ErrorContent">
		<complexType>
			<sequence>
				<element minOccurs="1" maxOccurs="1" name="ErrorNumber" type="string" />
				<element minOccurs="1" maxOccurs="1" name="KeyAttribute" type="string" />
				<element minOccurs="1" maxOccurs="1" name="KeyValues" type="string" />
				<element minOccurs="1" maxOccurs="1" name="CheckAttribute" type="string" />
				<element minOccurs="1" maxOccurs="1" name="CheckValue" type="string" />
				<element minOccurs="1" maxOccurs="1" name="ErrorText" type="string" />
			</sequence>
		</complexType>
	</element>

	<element name="StipBezieher">
		<complexType>
			<sequence>
				<element minOccurs="1" maxOccurs="1" name="Semester" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Studienjahr" type="string" />
				<element minOccurs="1" maxOccurs="1" name="PersKz" type="string" />
				<element minOccurs="1" maxOccurs="1" name="SVNR" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Familienname" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Vorname" type="string" />
				<element minOccurs="1" maxOccurs="1" name="Typ" type="string" />
				<element minOccurs="0" maxOccurs="1" name="PersKz_Antwort" type="string" />
				<element minOccurs="0" maxOccurs="1" name="SVNR_Antwort" type="string" />
				<element minOccurs="0" maxOccurs="1" name="Familienname_Antwort" type="string" />				
				<element minOccurs="0" maxOccurs="1" name="Vorname_Antwort" type="string" />
				<element minOccurs="0" maxOccurs="1" name="Ausbildungssemester" type="positiveInteger" />
				<element minOccurs="0" maxOccurs="1" name="StudStatusCode" type="positiveInteger" />
				<element minOccurs="0" maxOccurs="1" name="BeendigungsDatum" type="string" />
				<element minOccurs="0" maxOccurs="1" name="VonNachPersKz" type="string" />
				<element minOccurs="0" maxOccurs="1" name="Studienbeitrag" type="float" />
				<element minOccurs="0" maxOccurs="1" name="Inskribiert" type="string" />
				<element minOccurs="0" maxOccurs="1" name="Erfolg" type="float" />
				<element minOccurs="0" maxOccurs="1" name="OrgFormTeilCode" type="positiveInteger" />
				<element minOccurs="1" maxOccurs="1" name="AntwortStatusCode" type="positiveInteger" />
			</sequence>
		</complexType>
	</element>
	
	</schema>
	</wsdl:types>
	
	
    <wsdl:message name="GetStipRequest">
        <wsdl:part name="ErhKz" type="xsd:string"></wsdl:part>
        <wsdl:part name="AnfragedatenID" type="xsd:string"></wsdl:part>
		<wsdl:part name="Bezieher" element="xsd1:Stipendiumsbezieher" ></wsdl:part> 
    </wsdl:message>
 
    <wsdl:message name="GetStipResponse">
        <wsdl:part name="ErhKz" type="xsd:string"></wsdl:part>
		<wsdl:part name="AnfragedatenID" type="xsd:string"></wsdl:part>
		<wsdl:part name="StipBezieher" element="xsd1:StipBezieher" ></wsdl:part>
    </wsdl:message>
 
	<wsdl:message name="getErrorCodeRequest">
        <wsdl:part name="ErhKz" type="xsd:string"></wsdl:part>
        <wsdl:part name="StateCode" type="xsd:string"></wsdl:part>
		<wsdl:part name="StateMessage" type="xsd:string"></wsdl:part>
		<wsdl:part name="ErrorStatusCode" type="xsd:string"></wsdl:part>
		<wsdl:part name="JobID" type="xsd:string"></wsdl:part>
		<wsdl:part name="EContent" element="xsd1:ErrorContent" ></wsdl:part> 
    </wsdl:message>
 
	 <wsdl:message name="getErrorCodeResponse">
        <wsdl:part name="Value" type="xsd:string"></wsdl:part>
    </wsdl:message>
    
	 <wsdl:portType name="ConfigPortType" >
        <wsdl:operation name="getStipDaten">
            <wsdl:input message="tns:GetStipRequest"></wsdl:input>
            <wsdl:output message="tns:GetStipResponse"></wsdl:output>        
        </wsdl:operation>
		<wsdl:operation name="getErrorCode">
            <wsdl:input message="tns:getErrorCodeRequest"></wsdl:input> 
			<wsdl:output message="tns:getErrorCodeResponse"></wsdl:output>
		</wsdl:operation>
    </wsdl:portType>

    <wsdl:binding name="ConfigBinding" type="tns:ConfigPortType">
        <soap:binding style="rpc" transport="http://schemas.xmlsoap.org/soap/http" />
        <wsdl:operation name="getStipDaten">
            <soap:operation soapAction="<?php echo APP_ROOT; ?>soap/getStipDaten" />
            <wsdl:input> 
                <soap:body use="encoded" namespace="http://localhost/soap/" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </wsdl:input>
            <wsdl:output>
                <soap:body use="encoded" namespace="http://localhost/soap/" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
            </wsdl:output>
        </wsdl:operation> 
		<wsdl:operation name="getErrorCode">
            <soap:operation soapAction="<?php echo APP_ROOT; ?>soap/getErrorCode" />
            <wsdl:input> 
                <soap:body use="encoded" namespace="http://localhost/soap/" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"/>
            </wsdl:input>
			<wsdl:output>
                <soap:body use="encoded" namespace="http://localhost/soap/" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
            </wsdl:output>
        </wsdl:operation> 
    </wsdl:binding>  
  
    <wsdl:service name="WS-Projekt">
        <wsdl:port name="ConfigWebservicePort" binding="tns:ConfigBinding">
            <soap:address location="<?php echo APP_ROOT; ?>soap/stip.soap.php"/>
        </wsdl:port>
    </wsdl:service>
</wsdl:definitions>