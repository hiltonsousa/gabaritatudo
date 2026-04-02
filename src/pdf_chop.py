from pypdf import PdfReader, PdfWriter

input_file = input("Input file: ").replace("'", "")
reader = PdfReader(input_file)
writer = PdfWriter()

start = int(input("Start page: "))  
end = int(input("End page: "))
output_file = input("Output file: ")        

for i in range(start, end):
    writer.add_page(reader.pages[i])

with open(output_file, "wb") as f:
    writer.write(f)